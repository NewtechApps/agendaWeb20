<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class empresa extends Model
{
    protected $table = 'empresa'; 
    protected $primaryKey = 'id_empresa';
    public $timestamps = false;
    public $autoincrement = false;


    public static $incRules = [
        'i_razao_social'     => ['required'],
        'i_nome_fantasia'    => ['required'],
        'i_tipo_pessoa'      => ['required'],
        'i_cpf_cnpj'         => ['required'],
        'i_estado'           => ['required','not_in:null'],
        'i_municipio'        => ['required'],
        'i_endereco'         => ['required'],
        'i_cep'              => ['required'],
        'i_telefone_fixo'    => ['required'],
    ];

    public static $incTranslate = [
        'i_razao_social'     => 'Razão Social',
        'i_nome_fantasia'    => 'Nome Fantasia',
        'i_tipo_pessoa'      => 'Tipo de Empresa',
        'i_cpf_cnpj'         => 'CPF/CNPJ',
        'i_estado'           => 'Estado/UF',
        'i_municipio'        => 'Município',
        'i_endereco'         => 'Endereço',
        'i_cep'              => 'CEP',
        'i_telefone_fixo'    => 'Tel. Fixo',
    ];

    public static $updRules = [
        'u_razao_social'     => ['required'],
        'u_nome_fantasia'    => ['required'],
        'u_tipo_pessoa'      => ['required'],
        'u_cpf_cnpj'         => ['required'],
        'u_estado'           => ['required','not_in:null'],
        'u_municipio'        => ['required'],
        'u_endereco'         => ['required'],
        'u_cep'              => ['required'],
        'u_telefone_fixo'    => ['required'],
    ];

    public static $updTranslate = [
        'u_razao_social'     => 'Razão Social',
        'u_nome_fantasia'    => 'Nome Fantasia',
        'u_tipo_pessoa'      => 'Tipo de Empresa',
        'u_cpf_cnpj'         => 'CPF/CNPJ',
        'u_estado'           => 'Estado/UF',
        'u_municipio'        => 'Município',
        'u_endereco'         => 'Endereço',
        'u_cep'              => 'CEP',
        'u_telefone_fixo'    => 'Tel. Fixo',
    ];



    public static function getId()
    {
        return (DB::table('empresa')
                ->orderBy('id_empresa', 'desc')
                ->value('id_empresa'))+1;
    }
}
