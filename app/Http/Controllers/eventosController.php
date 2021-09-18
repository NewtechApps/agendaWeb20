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

class EventosController extends Controller
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

                // Caso seja alteração de Registro.
                if($request->id_geral){
                    
                    // Caso evento original seja Múltiplas datas.
                    $evento = Evento::where('id_evento', '=', $request->id_geral)->first();
                    if($evento->tipo_data=='1'){

                        Evento::where('id_evento', '=', $request->id_geral)->delete();
                        Evento::gerarAgendas($request);
                    
                    // Caso evento original seja de Intervalo.
                    } else {
                        Evento::where('id', '=', $request->id_evento)->delete();
                        Evento::gerarAgendas($request);
                    }

                // Caso seja inclusão de Novas Agendas.
                } else {
                    Evento::gerarAgendas($request);
                }



                // Envio de notificação por e-mail.
                if($request->status=="1"){
                    $user = Usuario::find($request->id_usuario);
                    if($user->notificacao_agenda=="S"){
        
                        $empresa = DB::table('usuario_empresa')
                                    ->where('id_usuario', '=', $request->id_usuario)
                                    ->where('id_empresa', '=', $request->empresa)
                                    ->first();
        
                        if($empresa->status==0){
                            $user->email = $empresa->email;
                            $user->notify( new AgendaInsert($request->all()) );
                        }
                    }
                }
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
            $events  = DB::table('consultaagendas')
                        ->join('usuario_empresa', function($join) use ($usuario) {
                            $join->on('usuario_empresa.id_empresa', '=', 'empresa')
                                ->where([
                                    ['usuario_empresa.status',     '=', '0'],
                                    ['usuario_empresa.id_usuario', '=', $usuario],
                                ]);
                            }
                        )
        
                        ->where('usuario', '=', Auth::user()->id_usuario)
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


        $usuarios = DB::table('relatorioAgendas')
                    ->select('LINHA', 'USUARIO', 'NOME')
                    ->whereBetween('DATACAL', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->where(function ($query) use ($usuario) { if ($usuario) { $query->whereIn('USUARIO', $usuario  ); } })
                    ->groupBy('LINHA')->groupBy('USUARIO')->groupBy('NOME')
                    ->orderBy('LINHA')->orderBy('NOME')
                    ->get();
    
        $eventos =  DB::table('relatorioAgendas')
                    ->whereBetween('DATACAL', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->where(function ($query) use ($usuario) { if ($usuario) { $query->whereIn('USUARIO', $usuario  ); } })
                    ->orderBy('LINHA')->orderBy('NOME')->orderBy('DATACAL')
                    ->get();
                
        return view("cadastros.eventos.relatorio")
               ->with('dates'   , $dates)
               ->with('eventos' , $eventos)
               ->with('usuarios', $usuarios);
    }

    public function dashboard(Request $request)
    {
 
        $diasFeriados = 0;
        $totalAlocadas = 0;
        $dataDe  = $request->dataInicial ?? Carbon::now()->startOfWeek();
        $dataAte = $request->dataFinal   ?? Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $dataAte = Carbon::parse($dataAte)->endOfDay();

        $feriados = DB::table('feriados')->whereBetween('data', [ $dataDe, $dataAte ])->get();
        foreach($feriados as $feriado){
            $diasFeriados =+ Carbon::parse($feriado->data)->isWeekday() ?? 1;
        }


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

        $diffDays   = Carbon::parse($dataDe)->diffInWeekdays( $dataAte ); 
        $diffDays   = $diffDays-$diasFeriados;
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