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
        $field  = $request->get('field')  != '' ? $request->get('field') : 'descricao';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';

        $tiposServico = DB::table('linha_produto')
                        ->orwhere('descricao' , 'like', '%' . $search . '%')                
                        ->orderBy($field, $sort)
                        ->get();
        return view("cadastros.tipoServico.index")->with('tiposServico', $tiposServico);
    }


    public function create(Request $request)
    {
        $linha = new tipoServico();
        $linha->id_linha_produto = tipoServico::getId();
        $linha->descricao = $request->descricao;
        $linha->save();
        return redirect($request->header('referer'));
    }
  


    public function delete(Request $request)
    {
        try {

            DB::table('linha_produto')->where('id_linha_produto', '=', $request->id_linha_produto)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
            return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    
    
}