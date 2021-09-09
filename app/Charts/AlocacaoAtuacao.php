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
    public function __construct( $dataDe, $dataAte, $diffDays )
    {
        parent::__construct();

        $horasMultipla = DB::table('events')
                        ->select('linha_produto.id_linha_produto', 'descricao', DB::Raw('count(*) as quantidade') )
                        ->join('usuario', 'events.id_usuario', '=', 'usuario.id_usuario')
                        ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                        ->whereBetween('start', [ $dataDe, $dataAte ])
                        ->where('events.status', '=', '1')
                        ->where('usuario.status', '=' , '0')
                        ->where('usuario.id_perfil' , '<>', '1')
                        ->where('usuario.id_usuario', '<>', '1')
                        ->where('tipo_periodo', '=', '0')
                        ->where('tipo_data', '=', '1')
                        ->whereNull('deleted_at')
                        ->groupBy('linha_produto.id_linha_produto')
                        ->orderBy('quantidade', 'desc')->get();
        log::Debug($horasMultipla);
        foreach($horasMultipla as $multiplas){
            $multiplas->quantidade = ($multiplas->quantidade*8);
        }


        $disponiveis = DB::table('usuario')
                        ->select('linha_produto.id_linha_produto', 'descricao', DB::raw('count(*) as quantidade') )
                        ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                        ->where('usuario.status', '=' , '0')
                        ->where('usuario.id_perfil' , '<>', '1')
                        ->where('usuario.id_usuario', '<>', '1')
                        ->groupBy('linha_produto.id_linha_produto')
                        ->orderBy('quantidade','desc')->get();

        foreach($disponiveis as $disponivel){
            $disponivel->quantidade = ($disponivel->quantidade*$diffDays*8);
        }

        $capacidade = $disponiveis->pluck('quantidade','descricao');
        $alocadas   = $horasMultipla->pluck('quantidade','descricao');
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
