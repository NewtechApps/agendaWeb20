<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class usuarioEmpresa extends Model
{
    protected $table = 'usuario_empresa'; 
    public $timestamps = false;
    public $autoincrement = false;
}
