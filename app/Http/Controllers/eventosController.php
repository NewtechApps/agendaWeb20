<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DateTime;
use Session;
use Validator;

use App\Models\Evento;    
use App\Models\Usuario;
use App\Models\calendar;    

use App\Events\AgendaCriada;
use App\Events\AgendaExcluida;

use App\Notifications\AgendaInsert;
use App\Notifications\AgendaDelete;

use App\Charts\AlocacaoTotal;
use App\Charts\AlocacaoAtuacao;

class eventosController extends Controller
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
       return view("cadastros.eventos.index");
    }

    public function create(Request $request)
    {

        $validator = Validator::make( $request->all(), Evento::$rules, [], Evento::$translate);
        if ($validator->fails()) {
        return response()->json(['code'=>'401', 'erros'=>$validator->messages()]);
        } else {  

            try {
                
                if($request->dataSelecao=='2'){
                Evento::where('id', '=', $request->id_evento)->delete();
                } else {
                Evento::where('id_evento', '=', $request->id_geral)->delete();
                }

                Evento::gerarAgendas($request);
                if($request->status=="1"){
                    $user = Usuario::find($request->id_usuario);
                    if($user->notificacao_agenda=="S"){
        
                        $empresa = DB::table('usuario_empresa')
                                    ->where([
                                        ['id_usuario', '=', $request->id_usuario],
                                        ['id_empresa', '=', $request->empresa],
                                    ])->first();
        
                        if($empresa->status==0){
                            $user->email = $empresa->email;
                            $user->notify( new AgendaInsert($request->all()) );
                        }
                    }
                }
        
                //event(new AgendaCriada( $request->all() ));
                return response()->json(['code'=>'200']);

            } catch (\Exception $e) {
                log::Debug('ERRO: '.$e);
                return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
            }
        }
    }
  


    public function delete(Request $request)
    {
        try {

            $event = DB::table('events')->
                     select('events.*', 'trabalho.descricao as descricao')->
                     join('trabalho','id_trabalho', '=', 'events.tipo_trabalho')->
                     where('id', '=', $request->id_evento)->first();

            if($event->status=="1"){
                $user = Usuario::find($event->id_usuario);
                if($user->notificacao_agenda=="S"){
    
                    $empresa = DB::table('usuario_empresa')
                            ->where([
                                ['id_usuario', '=', $event->id_usuario],
                                ['id_empresa', '=', $event->empresa],
                            ])->first();
    
                    if($empresa->status==0){
                        $user->email = $empresa->email;
                        $user->notify( new AgendaDelete( $event ));
                    }
                }
            }
    
            Evento::where('id', '=', $request->id_evento)->delete();
            return response()->json(['code'=>'200']);

        } catch (\Exception $e) {
            log::Debug('ERRO: '.$e);
            return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
        }
    }    
 
    public function deleteAll(Request $request)
    {

        try {

            $event = DB::table('events')->
                     select('events.*', 'trabalho.descricao as descricao')->
                     join('trabalho','id_trabalho', '=', 'events.tipo_trabalho')->
                     where('id_evento', '=', $request->id_geral)->first();

            $event->start = DB::table('events')->where('id_evento', '=', $request->id_geral)->min('start');
            $event->end   = DB::table('events')->where('id_evento', '=', $request->id_geral)->max('end');
            if($event->status=="1"){
                $user = Usuario::find($event->id_usuario);
                if($user->notificacao_agenda=="S"){
    
                    $empresa = DB::table('usuario_empresa')
                            ->where([
                                ['id_usuario', '=', $event->id_usuario],
                                ['id_empresa', '=', $event->empresa],
                            ])->first();
    
                    if($empresa->status==0){
                        $user->email = $empresa->email;
                        $user->notify( new AgendaDelete( $event ));
                    }
                }
            }
        
            Evento::where([
                    ['id_evento', '=', $request->id_geral],
                    ['start', '>', now()]
                    ])->delete();
            return response()->json(['code'=>'200']);

        } catch (\Exception $e) {
            log::Debug('ERRO: '.$e);
            return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
        }
    }    

    
    public function consulta(Request $request)
    {

        if(Auth::user()->id_perfil=='1') {
            
            $search = $request->filterTitle;
            $status = $request->filterStatus;
            $usuario  = $request->filterUsuario;
            $empresa  = $request->filterEmpresa;
            $trabalho = $request->filterTrabalho;

            $events = DB::table('consultaagendas')
                        ->whereBetween('start', [ $request->start, $request->end ])
                        ->where(function ($query) use ($search) {
                           $query->where('nome', 'like' , '%' . $search . '%')
                               ->orWhere('title', 'like', '%' . $search . '%');
                        })
                        ->where(function ($query) use ($status)  { if ($status!='2'){ $query->where('status', '=' , $status);  } })
                        ->where(function ($query) use ($usuario) { if ($usuario) { $query->whereIn('usuario' , explode(',', $usuario) ); } })
                        ->where(function ($query) use ($empresa) { if ($empresa) { $query->whereIn('empresa' , explode(',', $empresa) ); } })
                        ->where(function ($query) use ($trabalho) {if ($trabalho){ $query->whereIn('tipo_trabalho' , explode(',', $trabalho) ); } })
                        ->get();
            return response()->json($events);

        } else {

            $usuario = Auth::user()->id_usuario;
            $events = DB::table('events')
                        ->select(
                            DB::raw("CONCAT(usuario.nome,' - ',events.title) AS title"),
                            DB::raw("CONCAT('#',trabalho.cor) AS backgroundColor"),
                            DB::raw("CONCAT('#',trabalho.cor) AS borderColor"),
                            
                            'empresa', 'tipo_trabalho', 'start', 'end', 'tipo_data', 
                            'id_evento AS id', 
                            'events.status AS status',
                            'events.title AS descricao', 
                            'start AS datainicial', 
                            'usuario.id_usuario AS usuario',
                            'trabalho.descricao AS descTrabalho',
                            'usuario_empresa.status AS statusEmpresa'
                        )
                        ->join('usuario' , 'usuario.id_usuario',   '=', 'events.id_usuario')
                        ->join('trabalho', 'trabalho.id_trabalho', '=', 'events.tipo_trabalho')
                        ->join('usuario_empresa', function($join) use ($usuario) {
                            $join->on('usuario_empresa.id_empresa', '=', 'events.empresa')
                                ->where([
                                    ['usuario_empresa.status',     '=', '0'],
                                    ['usuario_empresa.id_usuario', '=', $usuario],
                                ]);
                            }
                        )
        
                        ->where('events.id_usuario', '=', Auth::user()->id_usuario)
                        ->whereBetween('start', [ $request->start, $request->end ])
                        ->get();

            return response()->json($events);
        }

    }

    public function relatorio(Request $request)
    {

        $status   = $request->filterStatus;
        $empresa  = $request->checkEmpresas ?? '';
        $usuario  = $request->checkUsuarios ?? '';
        $trabalho = $request->checkTrabalhos ?? '';

        $dtDe  = Carbon::parse($request->data_rel_ini);
        $dtAte = Carbon::parse($request->data_rel_fin);
        for($d = $dtDe; $d->lte($dtAte); $d->addDay()) {

            if(!DB::table('calendar')->where('id_data', '=', $d->format('Y-m-d') )->first()){
                $calendar = new calendar();
                $calendar->id_data = $d->format('Y-m-d');            
                $calendar->save();
            };
        }                    


        $dates = DB::table('calendar')
                ->select('calendar.id_data', 'feriados.descricao')
                ->leftjoin('feriados', 'feriados.data',   '=', 'calendar.id_data')
                ->whereBetween('id_data', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                ->get();


        $events =  DB::table('relatorioAgendas')
                    ->whereBetween('DATACAL', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->where(function ($query) use ($usuario) { if ($usuario) { $query->whereIn('USUARIO', $usuario  ); } })
                    ->orderBy('LINHA')->orderBy('NOME')->orderBy('DATACAL')
                    ->get();
                
        return view("cadastros.eventos.relatorio")->with('dates', $dates)->with('events', $events);
    }

    public function dashboard(Request $request)
    {
 
        $totalAlocadas = 0;
        $dataDe  = $request->dataInicial ?? Carbon::now()->startOfWeek();
        $dataAte = $request->dataFinal   ?? Carbon::now()->endOfWeek(Carbon::FRIDAY);
        
        $feriados = DB::table('feriados')
                    ->whereBetween('data', [ $dataDe, $dataAte ])->count();

        $usuarios = DB::table('usuario')
                    ->where('status'    , '=' , '0')
                    ->where('id_perfil' , '<>', '1')
                    ->where('id_usuario', '<>', '1')
                    ->orderBy('nome','asc')->get();

        foreach($usuarios as $usuario){

            $horasMultipla = DB::table('events')
                                ->select('id_usuario', 'tipo_periodo', 
                                    DB::Raw('(CASE WHEN tipo_periodo=0 THEN count(*)*8 ELSE count(*)*4 END) as totalHoras') )
                                ->whereBetween('start', [ $dataDe, $dataAte ])
                                ->where('id_usuario'  , '=', $usuario->id_usuario)
                                ->where('status'      , '=', '1')
                                ->where('tipo_data'   , '=', '1')
                                ->whereNull('deleted_at')
                                ->groupBy('id_usuario', 'tipo_periodo')
                                ->get();
            
            $eventosIntervalo = DB::table('events')
                                ->where('start', '>=', $dataDe)
                                ->where('end',   '<=', $dataAte)
                                ->where('id_usuario' , '=', $usuario->id_usuario)
                                ->where('status'     , '=', '1')
                                ->where('tipo_data'  , '=', '2')
                                ->whereNull('deleted_at')
                                ->get();
            
            $horasIntervalo = 0;
            foreach($eventosIntervalo as $intervalo){
                
                $eventDays = Carbon::parse( $intervalo->start )->diffInWeekdays( Carbon::parse($intervalo->end)->endOfDay() );
                $horasIntervalo += ( $eventDays * ($intervalo->tipo_periodo=='0' ? 8 : 4 ));
            }

            $totalAlocadas += ($horasMultipla->sum('totalHoras') + $horasIntervalo);
        }

        $diffDays   = Carbon::parse($dataDe)->diffInWeekdays( Carbon::parse($dataAte)->endOfDay()); 
        $diffDays   = $diffDays-$feriados;
        $totalHoras = $diffDays*8*$usuarios->count();

        $chartTotal   = new AlocacaoTotal( $totalHoras, $totalAlocadas );
        $chartAtuacao = new AlocacaoAtuacao( $dataDe, $dataAte, $diffDays );

        return view("cadastros.eventos.dashboard")
                ->with('usuarios', $usuarios)
                ->with('totalHoras', $totalHoras)
                ->with('totalAlocadas', $totalAlocadas)
                ->with('chartTotal'  , $chartTotal)
                ->with('chartAtuacao', $chartAtuacao);
    }
}