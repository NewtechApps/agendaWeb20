<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('razao_social', 200);
            $table->string('nome_fantasia', 200);
            $table->string('endereco', 100);
            $table->string('cep', 20);
            $table->string('estado', 20);
            $table->string('municipio', 30);
            $table->string('complemento', 100);
            $table->string('telefone_fixo', 15);
            $table->string('telefone_celular', 20);
            $table->string('tipo_pessoa', 1);
            $table->string('cpf_cnpj', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
