<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class perfil extends Model
{
    protected $table = 'perfil'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('perfil')
                ->orderBy('id_perfil', 'desc')->value('id_perfil'))+1;

    }


    public static $incRules = [
        'i_nome'      => ['required'],
        'i_descricao' => ['required'],
    ];

    public static $incTranslate = [
        'i_nome'      => 'Nome',
        'i_descricao' => 'Descrição',
    ];


    public static $updRules = [
        'u_nome'      => ['required'],
        'u_descricao' => ['required'],
    ];

    public static $updTranslate = [
        'u_nome'      => 'Nome',
        'u_descricao' => 'Descrição',
    ];

}
