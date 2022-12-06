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

use App\Models\perfil;    
use App\Models\perfilRotina;    
class perfilUsuarioController extends Controller
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
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nome';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';

 
        $perfil  = DB::table('perfil')
                   ->where('nome', 'like', '%' . $search . '%')
                   ->orwhere('descricao' , 'like', '%' . $search . '%')                
                   ->orderBy($field, $sort)
                   ->get();

        $testes = DB::table('rotina')->orderBy('id_rotina', 'asc')->get();
        return view("cadastros.perfil.index")->with('perfil', $perfil)
                                             ->with('testes', $testes);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make( $request->all(), perfil::$incRules, [], perfil::$incTranslate);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                
                $id_perfil = perfil::getId();
                $perfil = new perfil();
                $perfil->id_perfil = $id_perfil;
                $perfil->nome      = $request->nome;
                $perfil->descricao = $request->descricao;
                $perfil->save();

                for ($i = 0; $i < count($request->codRotina); $i++) { 
                    if($request->idSelect[$i]=="1"){
                        $rotina = new perfilRotina();
                        $rotina->id_perfil = $id_perfil;
                        $rotina->id_rotina = $request->codRotina[$i];
                        $rotina->edicao       = 0;
                        $rotina->visualizacao = 0;
                        $rotina->save();
                    }
                }
            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }
  


    public function delete(Request $request)
    {
        try {

            DB::table('perfil_rotina')->where('id_perfil', '=', $request->id_perfil)->delete();
            DB::table('perfil')->where('id_perfil', '=', $request->id_perfil)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
            return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    
    
}