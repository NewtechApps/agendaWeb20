<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use Session;

use App\Models\usuario;    
use App\Models\usuarioEmpresa;
class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {

        
        // Ajuste perfil.
        /*
        $usuarios  = DB::table('usuario')->get();
        foreach ($usuarios as $usuario) {

            $perfil = DB::table('usuario_perfil')->where('id_usuario', '=', $usuario->id_usuario)->first();

            if ($perfil){
                DB::table('usuario')
                ->where('id_usuario', '=', $usuario->id_usuario)
                ->update([
                    'id_perfil' => $perfil->id_perfil,
                ]);
            }
        }
        */



        // Ajuste usuario-empresa. 
        /*
        $usuarios  = DB::table('usuario')->where('status', '=', '0')->get();
        foreach ($usuarios as $usuario) {


            $mail = DB::table('usuario_empresa')->where([
            ['id_usuario', '=', $usuario->id_usuario],
            ['id_empresa', '=', 5],
            ])->first();
            if (!$mail){
                $empresa = new usuarioEmpresa();
                $empresa->id_usuario = $usuario->id_usuario;
                $empresa->id_empresa = 5;
                $empresa->status = 0;
                $empresa->save();
            }


            $mail = DB::table('usuario_empresa')->where([
            ['id_usuario', '=', $usuario->id_usuario],
            ['id_empresa', '=', 5],
            ])->first();
            if (!$mail){
                $empresa = new usuarioEmpresa();
                $empresa->id_usuario = $usuario->id_usuario;
                $empresa->id_empresa = 6;
                $empresa->status = 0;
                $empresa->save();
            }
        }
        */

        $search = $request->get('search');
        $field  = $request->get('field')  ?? 'nome';
        $sort   = $request->get('sort')   ?? 'asc';
        $status = $request->get('status') ?? '0';
        
        $usuarios  = DB::table('usuario')
                    ->select('usuario.*', 'empresa.razao_social', 'linha_produto.descricao')
                    ->join('empresa', 'usuario.id_empresa','=', 'empresa.id_empresa')
                    ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                    ->where(function ($query) use ($search) {
                        $query->where('nome', 'like' , '%' . $search . '%')
                            ->orWhere('usuario.email', 'like', '%' . $search . '%')
                            ->orWhere('linha_produto.descricao', 'like', '%' . $search . '%');
                    })
                    ->where(function ($query) use ($status) { if ($status!='2'){ $query->where('usuario.status', '=' , $status); } })
                    ->orderBy($field, $sort)
                    ->get();
        

        $empresas     = DB::table('empresa')->orderBy('razao_social','asc')->get();
        $perfisCombo  = DB::table('perfil')->orderBy('id_perfil','asc')->pluck('nome','id_perfil');

        return view("cadastros.usuario.index")->with('usuarios'   , $usuarios)
                                              ->with('empresas'   , $empresas)
                                              ->with('perfisCombo', $perfisCombo);
    }

    public function store(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'login' => $request->id_usuario ? 'required' : 'required|unique:usuario,login',
            'email' => $request->id_usuario ? 'required' : 'required|email|unique:usuario,email',
            'nome'  => 'required',
            'telefone'  => 'required',
            'id_perfil' => 'required',
            'id_empresa'=> 'required',
            'id_linha_produto' => 'required',
            ], [], Usuario::$translate);


        if ($validator->fails()) {
        return response()->json(['code'=>'401', 'erros'=>$validator->messages()]);
        } else {  

            try {

                if($request->id_usuario){                

                    $idUsuario = $request->id_usuario;
                    DB::table('usuario')
                    ->where('id_usuario', '=', $idUsuario)
                    ->update([
                        'nome'      => $request->nome,
                        'email'     => $request->email,
                        'login'     => $request->login,
                        'status'    => $request->status,
                        'telefone'  => $request->telefone,
                        'id_empresa'=> $request->id_empresa,
                        'id_perfil' => $request->id_perfil,
                        'idEstado'  => $request->codEstado,
                        'idCidade'  => $request->codMunicipio,
                        'id_linha_produto'  => $request->id_linha_produto,
                        'especialidade'     => $request->especialidade,
                        'data_nascimento'   => $request->data_nascimento,
                        'notificacao_agenda'=> $request->notificacao_agenda, 
                    ]);


                    if($request->status=="1"){
                        DB::table('events')->where([
                            ['id_usuario', '=', $idUsuario],
                            ['start', '>', now()]
                        ])->delete();
                    }

                } else {

                    $usuario = new Usuario();
                    $usuario->nome   = $request->nome;
                    $usuario->email  = $request->email;
                    $usuario->login  = $request->login;
                    $usuario->status = $request->status;
                    $usuario->senha  = Hash::make("123456");
                    $usuario->idEstado   = $request->codEstado;
                    $usuario->idCidade   = $request->codMunicipio;
                    $usuario->telefone   = $request->telefone;
                    $usuario->id_empresa = $request->id_empresa;
                    $usuario->id_perfil  = $request->id_perfil;
                    $usuario->id_linha_produto = $request->id_linha_produto;
                    $usuario->especialidade    = $request->especialidade;
                    $usuario->data_nascimento  = $request->data_nascimento;
                    $usuario->notificacao_agenda = $request->notificacao_agenda; 
                    $usuario->imagem = "";

                    $usuario->save();
                    $idUsuario = $usuario->id_usuario;
                }


                for ($i = 0; $i < count($request->arr_empresa); $i++) { 
                    if($request->arr_empresa[$i]){

                        $mail = DB::table('usuario_empresa')->where([
                                ['id_usuario', '=', $idUsuario],
                                ['id_empresa', '=', $request->arr_empresa[$i]],
                                ])->first();

                        if (empty($mail)){

                            $empresa = new usuarioEmpresa();
                            $empresa->id_usuario = $idUsuario;
                            $empresa->id_empresa = $request->arr_empresa[$i];
                            $empresa->email      = $request->arr_email[$i];
                            $empresa->status     = $request->arr_status[$i];
                            $empresa->save();
                        
                        } else {

                            DB::table('usuario_empresa')->where([
                                ['id_usuario', '=', $idUsuario],
                                ['id_empresa', '=', $request->arr_empresa[$i]],
                            ])->update([
                                'email'  => $request->arr_email[$i],
                                'status' => $request->arr_status[$i],
                            ]);
                        }
                    }
                }

                return response()->json(['code'=>'200']);
                
            } catch (\Exception $e) {
                log::Debug('ERRO: '.$e->getMessage());
                return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
            }   
        }
    }

    
    public function delete(Request $request)
    {
        try {
            DB::table('usuario_empresa')->where('id_usuario', '=', $request->id_usuario)->delete();
            DB::table('usuario')->where('id_usuario', '=', $request->id_usuario)->delete();
            return redirect($request->header('referer'));
        } catch (\Exception $e) {

            if(strpos($e->getMessage(), 'Cannot delete or update a parent row')>0){
                session::put('erros', 'Não é possível excluir esse registro. - MOTIVO: Esse Usuário já está sendo usada por outro cadastro'); 
                return redirect($request->header('referer'));
            } else {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
                return redirect($request->header('referer'))->with('errors', $e->getMessage());
            }
        }
    }    

    public function empresas($usuario)
    {

        return  DB::table('empresa')
                ->select('empresa.id_empresa','empresa.razao_social','usuario_empresa.email','usuario_empresa.status')
                ->leftJoin('usuario_empresa' , function($join) use ($usuario) {
                    $join->on('usuario_empresa.id_empresa', '=', 'empresa.id_empresa')
                        ->where('usuario_empresa.id_usuario', '=', $usuario);
                    }
                )
                ->orderBy('empresa.razao_social', 'asc')->get();
    }

    public function updateUser(Request $request)
    {

        $validator = Validator::make( $request->all(), Usuario::$updUserRules, [], Usuario::$updUserTranslate);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                DB::table('usuario')
                ->where('id_usuario', '=', Auth::user()->id_usuario)
                ->update([
                    'nome'     => $request->nome,
                    'email'    => $request->email,
                    'login'    => $request->login,
                    'telefone' => $request->telefone,
                    'senha'    => Hash::make($request->senha),
                    'notificacao_agenda'=> $request->notificacao_agenda, 
                ]);

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect('/');
        }
    }
}