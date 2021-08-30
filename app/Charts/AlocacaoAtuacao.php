<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlocacaoAtuacao extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct( $dataDe, $dataAte, $diffDays, $feriados )
    {
        parent::__construct();

        $disponiveis = DB::table('usuario')
                        ->select('linha_produto.id_linha_produto', 'descricao', DB::raw('count(*) as quantidade') )
                        ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                        ->where('usuario.status', '=' , '0')
                        ->where('usuario.id_perfil' , '<>', '1')
                        ->where('usuario.id_usuario', '<>', '1')
                        ->groupBy('linha_produto.id_linha_produto')
                        ->orderBy('quantidade','desc')->get();

        foreach($disponiveis as $disponivel){
            $disponivel->quantidade = ($disponivel->quantidade*$diffDays*8)-$feriados;
        }

        $capacidade = $disponiveis->pluck('quantidade','descricao');

        $this->labels( $capacidade->keys() );
        $this->dataset( 'Disponível', 'bar', $capacidade->values() )
            ->backgroundcolor(["#001a4d"])
            ->options([
                'borderWidth' => 1,
                'borderColor' => 'black',
        ]);
        
            /*
            $integralMultipla = DB::table('events')
                                ->join('usuario', 'events.id_usuario', '=', 'usuario.id_usuario')
                                ->whereBetween('start', [ $dataDe, $dataAte ])
                                //->where('id_usuario'  , '=', 127)
                                ->where('usuario.id_linha_produto', '=', $disponivel->id_linha_produto )
                                ->where('events.status', '=', '1')
                                ->where('tipo_data'    , '=', '1')
                                ->where('tipo_periodo' , '=', '0')
                                ->whereNull('deleted_at')
                                ->count()*8;

            $this->dataset( $disponivel->descricao, 'bar', [$integralMultipla])
                ->backgroundcolor(["#ff8000"])
                ->options([
                    'borderWidth' => 1,
                    'borderColor' => 'black',
                    'legend' => ['position' => 'left'],
            ]);
        */
    }
}
