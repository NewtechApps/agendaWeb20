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

use App\Models\TipoAgenda;    
class tipoAgendaController extends Controller
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

        $tiposAgenda = DB::table('trabalho')
                        ->where('descricao' , 'like', '%' . $search . '%')                
                        ->where(function ($query) use ($status) { if ($status!='2'){ $query->where('status', '=', $status); }})
                        ->orderBy($field, $sort)
                        ->get();
                        
        return view("cadastros.tipoAgenda.index")->with('tiposAgenda', $tiposAgenda);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
                     'descricao'   => ['required'],
                     'colorpicker' => ['required'],
                     ], [], [
                     'descricao'   => 'Descrição',
                     'colorpicker' => 'Cor',
                     ]);

        if ($validator->fails()) {
        return response()->json(['code'=>'401', 'erros'=>$validator->messages()]);
        } else {  

            try {

                TipoAgenda::updateOrCreate(
                ['id_trabalho' => $request->id_trabalho],
                [
                'descricao' => $request->descricao,
                'cor'       => substr($request->colorpicker,1,6),
                'status'    => '0',
                ],
                ); 
                
            } catch (\Exception $e) {
            log::Debug('ERRO: '.$e);
            return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
            }        
            return response()->json(['code'=>'200']);
        }
    }

    public function delete(Request $request)
    {

        try {
            
            $eventos = DB::table('events')->where('tipo_trabalho', '=', $request->id_trabalho)->get();
            if($eventos){
                session::put('erros', 'Não é possível excluir esse registro. - MOTIVO: Esse Tipo de Agenda já está sendo usado.'); 
            } else {
                DB::table('trabalho')->where('id_trabalho', '=', $request->id_trabalho)->delete();
            }

        } catch (\Exception $e) {
            session::put('erros', "Esse registro já está sendo usado por outro cadastro e não pode ser excluído!"); 
            log::Debug('ERRO: '.$e);
        }
        return redirect($request->header('referer'));
    }    

}