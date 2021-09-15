<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AlocacaoAtuacao extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct( $dataDe, $dataAte, $diffDays )
    {
        parent::__construct();

        $disponiveis = DB::table('usuario')
                        ->select('linha_produto.id_linha_produto', 
                            'descricao',
                            DB::Raw('count(*) as quantidade'), 
                            DB::Raw('count(*) as alocadas' ) )
                        ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                        ->where('usuario.status', '=' , '0')
                        ->where('usuario.id_perfil' , '<>', '1')
                        ->where('usuario.id_usuario', '<>', '1')
                        ->groupBy('linha_produto.id_linha_produto')
                        ->orderBy('quantidade','desc')->get();

        foreach($disponiveis as $disponivel){

            $horasMultipla = DB::table('events')
                            ->select('linha_produto.id_linha_produto', 'descricao', 'tipo_periodo', 
                                DB::Raw('(CASE WHEN tipo_periodo=0 THEN count(*)*8 ELSE count(*)*4 END) as totalHoras') )
                            ->join('usuario', 'events.id_usuario', '=', 'usuario.id_usuario')
                            ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                            ->whereBetween('start', [ $dataDe, $dataAte ])
                            ->where('events.status', '=', '1')
                            ->where('usuario.status', '=' , '0')
                            ->where('usuario.id_perfil' , '<>', '1')
                            ->where('usuario.id_usuario', '<>', '1')
                            ->where('tipo_data', '=', '1')
                            ->whereNull('deleted_at')
                            ->where('linha_produto.id_linha_produto', '=', $disponivel->id_linha_produto)
                            ->groupBy('linha_produto.id_linha_produto', 'descricao', 'tipo_periodo')
                            ->get();

            /*
            log::Debug('-----------------');
            log::Debug($disponivel->descricao);
            log::Debug($horasMultipla);
            */
            $eventosIntervalo = DB::table('events')
                              ->join('usuario', 'events.id_usuario', '=', 'usuario.id_usuario')
                              ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')

                              ->where('start', '>=', $dataDe)
                              ->where('end',   '<=', $dataAte)
                              ->where('events.status', '=', '1')

                              ->where('usuario.status', '=' , '0')
                              ->where('usuario.id_perfil' , '<>', '1')
                              ->where('usuario.id_usuario', '<>', '1')
                              ->where('tipo_data', '=', '2')
                              ->whereNull('deleted_at')
                              ->where('linha_produto.id_linha_produto', '=', $disponivel->id_linha_produto)
                              ->get();

            $horasIntervalo = 0;
            foreach($eventosIntervalo as $intervalo){
                $eventDays = Carbon::parse( $intervalo->start )->diffInWeekdays( Carbon::parse($intervalo->end)->endOfDay() );
                $horasIntervalo += ( $eventDays * ($intervalo->tipo_periodo=='0' ? 8 : 4 ));
            }

            //log::Debug($eventosIntervalo);
            $disponivel->quantidade = ($disponivel->quantidade*$diffDays*8);
            $disponivel->alocadas   = $horasMultipla->sum('totalHoras')+$horasIntervalo;

        }

        $capacidade = $disponiveis->pluck('quantidade','descricao');
        $alocadas   = $disponiveis->pluck('alocadas','descricao');
        $this->labels( $capacidade->keys() );

        $this->dataset( 'Disponível', 'bar', $capacidade->values() )
            ->backgroundcolor(["#001a4d"])
            ->options([
                'borderWidth' => 1,
                'borderColor' => 'black',
            ]);

        $this->dataset( 'Alocadas', 'bar', $alocadas->values() )
            ->backgroundcolor(["#ff8000"])
            ->options([
                'borderWidth' => 1,
                'borderColor' => 'black',
            ]);
    }
}
