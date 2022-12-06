<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class tipoServico extends Model
{
    protected $table = 'linha_Produto'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('linha_Produto')
                ->orderBy('id_linha_produto', 'desc')->value('id_linha_produto'))+1;

    }
}
