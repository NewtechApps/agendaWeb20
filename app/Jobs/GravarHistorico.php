<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GravarHistorico implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        /*
        ////// 2018 //////
        // Movendo eventos anteriores a 30/06/2018.
        $result = DB::table('events')->where('end','<=', '2018-06-30 23:59:59')->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->where('end','<=', '2018-06-30 23:59:59')->delete();
            log::debug('Execução 2018-06-30 ok!');
        };

        // Movendo eventos entre 01/07/2018 e 30/09/2018.
        $result = DB::table('events')->whereBetween('end', ['2018-07-01','2018-09-30 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2018-07-01','2018-09-30 23:59:59'])->delete();
            log::debug('Execução 2018-09-30 ok!');
        };

        // Movendo eventos entre 01/10/2018 e 31/12/2018.
        $result = DB::table('events')->whereBetween('end', ['2018-10-01','2018-12-31 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2018-10-01','2018-12-31 23:59:59'])->delete();
            log::debug('Execução 2018-12-31 ok!');
        };


        
        
        ////// 2019 //////
        // Movendo eventos entre 01/01/2019 e 30/06/2019.
        $result = DB::table('events')->whereBetween('end', ['2019-01-01','2019-06-30 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2019-01-01','2019-06-30 23:59:59'])->delete();
            log::debug('Execução 2019-06-30 ok!');
        };

        // Movendo eventos entre 01/07/2019 e 30/09/2019.
        $result = DB::table('events')->whereBetween('end', ['2019-07-01','2019-09-30 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2019-07-01','2019-09-30 23:59:59'])->delete();
            log::debug('Execução 2019-09-30 ok!');
        };

        // Movendo eventos entre 01/10/2019 e 31/12/2019.
        $result = DB::table('events')->whereBetween('end', ['2019-10-01','2019-12-31 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2019-10-01','2019-12-31 23:59:59'])->delete();
            log::debug('Execução 2019-12-31 ok!');
        };



        ////// 2020 //////
        // Movendo eventos entre 01/01/2020 e 31/03/2020.
        $result = DB::table('events')->whereBetween('end', ['2020-01-01','2020-03-31 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2020-01-01','2020-03-31 23:59:59'])->delete();
            log::debug('Execução 2020-03-31 ok!');
        };

        // Movendo eventos entre 01/04/2020 e 30/06/2020.
        $result = DB::table('events')->whereBetween('end', ['2020-04-01','2020-06-30 23:59:59'])->get();
        $data   = json_decode(json_encode($result), true);
        if (DB::table('eventos_historico')->insert($data)){
            DB::table('events')->whereBetween('end', ['2020-04-01','2020-06-30 23:59:59'])->delete();
            log::debug('Execução 2020-06-30 ok!');
        };
        */
    }
}
