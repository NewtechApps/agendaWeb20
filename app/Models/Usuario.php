<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use Notifiable;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $rememberTokenName = false;

    public $timestamps = false;
    public $autoincrement = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['login', 'email', 'senha', 'nome'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha',
    ];


    public function getAuthPassword(){  
        return $this->senha;
    }
    
    public static $translate = [
        'nome'      => 'Nome',
        'login'     => 'Login',
        'email'     => 'E-mail',
        'telefone'  => 'Telefone',
        'id_perfil' => 'Perfil',
        'id_empresa'=>'Empresa',
        'id_linha_produto' => 'Linha de Atuação',
    ];


    public static $updUserRules = [
        'nome'  => 'required',
        'telefone' => 'required',
        'senha'    => 'required', 
        'senhaConfirm' => 'required|same:senha' 
    ];
    public static $updUserTranslate = [
        'nome'     => 'Nome',
        'telefone' => 'Telefone',
        'senha'    => 'Senha',
        'senhaConfirm' => 'Confirmação de Senha',
    ];

}
