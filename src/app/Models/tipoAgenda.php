<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TipoAgenda extends Model
{
    protected $table      = 'trabalho'; 
    protected $primaryKey = 'id_trabalho';

    public $timestamps    = false;
    public $autoincrement = true;

    protected $fillable = ['descricao', 'cor', 'status'];
}
