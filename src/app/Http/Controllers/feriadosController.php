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

use App\Models\feriados;    
class feriadosController extends Controller
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

        $search = $request->search;
        $field  = $request->field ?? 'data';
        $sort   = $request->sort  ?? 'desc';

        $feriados = DB::table('feriados')
                    ->where('descricao' , 'like', '%' . $search . '%')                
                    ->orderBy($field, $sort)
                    ->get();
        return view("cadastros.feriados.index")->with('feriados', $feriados);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make($request->all(), [
                     'descricao'   => ['required'],
                     'data'        => ['required'],
                     ], [], [
                     'descricao'   => 'Descrição',
                     'data'        => 'Data',
                     ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $feriados = new feriados();
                $feriados->descricao = $request->descricao;
                $feriados->data      = $request->data;
                $feriados->save();
                
            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }


    public function delete(Request $request)
    {
        try {

            DB::table('feriados')->where('id_feriado', '=', $request->id_feriado)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
        return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    
    
}