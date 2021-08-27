<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Evento extends Model
{
    use SoftDeletes;
    protected $table = 'events'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('events')->orderBy('id_evento', 'desc')->value('id'))+1;
    }


    public static $rules = [
        'title'   => 'required',
        'empresa' => 'required',
        'datas'   => 'required',
        'id_usuario'    => 'required',
        'tipo_trabalho' => 'required',
    ];

    public static $translate = [
        'empresa' => 'Empresa',
        'datas'   => 'Datas',
        'title'   => 'Título/Descrição',
        'id_usuario'    => 'Usuário',
        'tipo_trabalho' => 'Tipo de Agenda',
    ];


    public static function gerarAgendas(request $request)
    {

        //log::Debug('------------------');
        $arrDatas = explode(',', trim($request->datas));
        $idEvento = Evento::getId();
        
        if($request->dataSelecao=='2'){ 

            if (count($arrDatas)>1){

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[1]))->endOfDay();


                $feriado = DB::table('feriados')->where('data', '=', substr($dataInicial,0,10))->first();
                if($feriado){ $dataInicial->addDay(); };
                if($dataInicial->isSaturday()) { $dataInicial->addDay(2); }
                elseif ($dataInicial->isSunday()){ $dataInicial->addDay(); };


                $feriado = DB::table('feriados')->where('data', '=', substr($dataFinal,0,10))->first();
                if($feriado){ $dataFinal->subDay(); };
                if ($dataFinal->isSaturday()) { $dataFinal->subDay(); } 
                elseif ($dataFinal->isSunday()){ $dataFinal->subDay(2); };


                $dataControle = Carbon::parse($dataInicial);
                $totalDias    = ($dataInicial->diffInDays($dataFinal));

                for($i=1; $i<=$totalDias; $i++) {

                   // log::Debug('Data Controle: '.$dataControle);
                    $dataControle->addDay()->endOfDay();
                    $feriado = DB::table('feriados')->where('data', '=', substr($dataControle,0,10))->first();


                    if ($dataControle->isSaturday() || $dataControle==$dataFinal || $feriado) {

                        $dataFimEvento = ($dataControle->isSaturday() || $feriado) ? $dataControle->subDay() : $dataFinal; 
                        Evento::createEvent( $idEvento, $dataInicial, $dataFimEvento, $request);
                        if ($dataControle==$dataFinal){ break; }


                        $dataInicial = Carbon::parse($dataFimEvento);
                        $dataInicial->addDay()->startOfDay();
                        $dataControle->addDay()->endOfDay();


                        if ($dataInicial->isSaturday() && $feriado){
                            $dataInicial->addDay(2)->startOfDay();
                            $dataControle->addDay()->endOfDay();
                        } else {

                            if($feriado){
                                $dataInicial->addDay()->startOfDay();
                                $dataControle->addDay()->endOfDay();
                            };

                            if($dataInicial->isSaturday()){
                                $dataInicial->addDay(2)->startOfDay();
                                $dataControle->addDay()->endOfDay();
                            };
                            
                            if(DB::table('feriados')->where('data', '=', substr($dataInicial,0,10))->first()){
                                $dataInicial->addDay()->startOfDay();
                                $dataControle->addDay()->endOfDay();
                            };
                        };
                    }; 

                };

            } else {

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();
                Evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
            };

        } else {

            if (count($arrDatas)>1){

                for ($i = 0; $i < count($arrDatas); $i++) { 
                    $dataInicial = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    $dataFinal   = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    Evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
                };

            } else {

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();
                Evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
            }
        };
    }

    public static function createEvent($idEvento, $dtIni, $dtFim, $request){

        $empresas = new Evento();
        $empresas->id_evento     = $idEvento;
        $empresas->title         = $request->title;
        $empresas->empresa       = $request->empresa;
        $empresas->tipo_trabalho = $request->tipo_trabalho;
        $empresas->status        = $request->status;
        $empresas->id_usuario    = $request->id_usuario;
        $empresas->tipo_data     = $request->dataSelecao;
        $empresas->id_creator    = Auth::user()->id_usuario;
        $empresas->start         = $dtIni;
        $empresas->end           = $dtFim;
        $empresas->save();
    }
}
