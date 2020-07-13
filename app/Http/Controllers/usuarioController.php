<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Session;

use App\Models\usuario;    
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

        /*
        // Ajuste perfil.
        $usuarios  = DB::table('usuario')->get();

        */



        $search = $request->get('search');
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nome';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';
        $status = $request->get('status') != '' ? $request->get('status'): '0';
        
        $usuarios  = DB::table('usuario')
                   ->select('usuario.*', 'empresa.razao_social', 'linha_produto.descricao')
                   ->join('empresa', 'usuario.id_empresa','=', 'empresa.id_empresa')
                   ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                   ->where(function ($query) use ($search) {
                    $query->where([
                            ['nome', 'like' , '%' . $search . '%'],
                        ])->orWhere([
                            ['usuario.email', 'like', '%' . $search . '%'],
                        ])->orWhere([
                            ['linha_produto.descricao', 'like', '%' . $search . '%'],
                        ]);
                    })->where(function ($query) use ($status) {
                        if ($status!='2'){
                            $query->where('status', '=' , $status);
                        }
                    })
                   ->orderBy($field, $sort)
                   ->get();
        

        $empresas         = DB::table('empresa')->orderBy('razao_social','asc')->get();
        $perfisCombo      = DB::table('perfil')->orderBy('id_perfil','asc')->pluck('nome','id_perfil');
        $empresasCombo    = DB::table('empresa')->orderBy('razao_social','asc')->pluck('razao_social','id_empresa');
        $tipoServicoCombo = DB::table('linha_produto')->orderBy('descricao','asc')->pluck('descricao','id_linha_produto');


        return view("cadastros.usuario.index")->with('usuarios', $usuarios)
                                              ->with('empresas', $empresas)
                                              ->with('perfisCombo',   $perfisCombo)
                                              ->with('empresasCombo', $empresasCombo)
                                              ->with('tipoServicoCombo', $tipoServicoCombo);
    }


    public function create(Request $request)
    {

        $usuario = new usuario();
        $usuario->id_usuario = usuario::getId();
        $usuario->nome   = $request->i_nome;
        $usuario->email  = $request->i_email;
        $usuario->login  = $request->i_login;
        $usuario->senha  = Hash::make($request->i_senha);
        $usuario->status = $request->i_status;
        $usuario->telefone  = $request->i_telefone;
        $usuario->id_empresa= $request->i_id_empresa;
        $usuario->id_perfil = $request->i_id_perfil;
        $usuario->linha_produto = $request->i_id_linha_produto;
        $usuario->especialidade = $request->i_especialidade;
        $usuario->data_nascimento = $request->i_data_nascimento;
        $usuario->save();



        return redirect($request->header('referer'));

    }
  


    public function delete(Request $request)
    {
        DB::table('usuario_perfil')->where('id_usuario', '=', $request->id_usuario)->delete();
        DB::table('usuario')->where('id_usuario', '=', $request->id_usuario)->delete();
        return redirect($request->header('referer'));
    }    
    
}