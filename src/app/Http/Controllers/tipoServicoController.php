<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Validator;
use Session;

use App\Models\tipoServico;    
class tipoServicoController extends Controller
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

        $search = $request->get('search');
        $field  = $request->get('field')  ?? 'descricao';
        $sort   = $request->get('sort')   ?? 'asc';
        $status = $request->get('status') ?? '0';

        $tiposServico = DB::table('linha_produto')
                        ->where(function ($query) use ($status) {
                            if ($status!='2'){
                                $query->where('status', '=' , $status);
                            }
                        })
                        ->where('descricao', 'like', '%' .$search. '%')                
                        ->orderBy($field, $sort)
                        ->get();
                        
        return view("cadastros.tipoServico.index")->with('tiposServico', $tiposServico);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make($request->all(), [
                     'descricao' => ['required'],
                     ], [], [
                     'descricao' => 'Descrição',
                     ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $linha = new tipoServico();
                $linha->id_linha_produto = tipoServico::getId();
                $linha->descricao = $request->descricao;
                $linha->status    = '0';
                $linha->save();

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }
  

    public function status(Request $request)
    {

        $status = $request->status=="0" ?? "1";
        try {

            DB::table('linha_produto')
            ->where('id_linha_produto', '=', $request->id_linha_produto)
            ->update(['status' => $status]);
            return redirect($request->header('referer'));

        } catch (\Exception $e) {

            session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    


    public function delete(Request $request)
    {
        try {

            DB::table('linha_produto')->where('id_linha_produto', '=', $request->id_linha_produto)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
            if(strpos($e->getMessage(), 'Cannot delete or update a parent row')>0){
                session::put('erros', 'Não é possível excluir esse registro. - MOTIVO: Essa Linha de Atuação já está sendo usada por outro cadastro'); 
                return redirect($request->header('referer'));
            } else {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
                return redirect($request->header('referer'))->with('errors', $e->getMessage());
            }
        }
    }    
    
}