<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class perfilRotina extends Model
{
    protected $table = 'perfil_rotina'; 
    public $timestamps = false;
    public $autoincrement = false;
}
