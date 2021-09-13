<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\Log;

class AlocacaoTotal extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct( $totalHoras, $totalAlocadas )
    {
        parent::__construct();

        $percAlocadas    = $totalAlocadas/$totalHoras*100;
        $percDisponiveis = 100-$percAlocadas; 

      //  $this->labels(['Alocadas', 'Disponíveis']);
        $this->options([
            'scales' => [
                'yAxes' => [ 'display' => false ],
                'xAxes' => [ 'display' => false ],
            ],
        ]); 

        
        $this->dataset('Alocação', 'doughnut', [ $percAlocadas, $percDisponiveis ])
            ->backgroundcolor(["#002080", "#ff8000"])
            ->options([
                'borderWidth' => 1,
                'borderColor' => 'black',
            ]); 

    }
}
