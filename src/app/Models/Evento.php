<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Evento extends Model
{
    use SoftDeletes;
    protected $table = 'events';
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('events')->orderBy('id', 'desc')->value('id'))+1;
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


    public static function gerarAgendas(Request $request)
    {

        // Caso seja Intervalo
        if($request->data_selecao=='2'){

          $idEvento = Evento::getId();
            $arrDatas = explode(',', trim($request->datas));

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

                    $dataControle->addDay()->endOfDay();
                    $feriado = DB::table('feriados')->where('data', '=', substr($dataControle,0,10))->first();


                    if ($dataControle->isSaturday() || $dataControle==$dataFinal || $feriado) {

                        $dataFimEvento = ($dataControle->isSaturday() || $feriado) ? $dataControle->subDay() : $dataFinal;
                        Evento::createEvento( $idEvento, $dataInicial, $dataFimEvento, $request);

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

                $idEvento = Evento::getId();
                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();
                Evento::createEvento( $idEvento, $dataInicial, $dataFinal, $request );
            };

        // Caso sejam Múltiplas
        } else {

            $idEvento = Evento::getId();
            $arrDatas = explode(',', trim($request->datas));

            if (count($arrDatas)>1){

                for ($i = 0; $i < count($arrDatas); $i++) {
                    $dataInicial = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    $dataFinal   = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    Evento::createEvento( $idEvento, $dataInicial, $dataFinal, $request );
                };

            } else {

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();
                Evento::createEvento( $idEvento, $dataInicial, $dataFinal, $request );
            };
        };
    }

    public static function createEvento($idEvento, $dtIni, $dtFim, $request)
    {

        $evento = new Evento();
        $evento->id_evento     = $idEvento;
        $evento->title         = $request->title;
        $evento->empresa       = $request->empresa;
        $evento->tipo_trabalho = $request->tipo_trabalho;
        $evento->tipo_periodo  = $request->tipo_periodo;
        $evento->tipo_alocacao = $request->tipo_alocacao;
        $evento->status        = $request->status;
        $evento->id_usuario    = $request->id_usuario;
        $evento->tipo_data     = $request->data_selecao;
        $evento->id_creator    = Auth::user()->id_usuario;
        $evento->start         = $dtIni;
        $evento->end           = $dtFim;
        $evento->save();
    }

}
