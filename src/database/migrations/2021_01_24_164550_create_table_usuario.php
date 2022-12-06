<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateTableUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('login', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('senha', 200);
            $table->string('nome' , 200);
            $table->string('telefone', 20);
            $table->date('data_nascimento');
            $table->string('imagem', 255);
            $table->string('especialidade', 255);
            $table->string('status', 1);
            $table->string('reset_password', 2);
            $table->bigInteger('id_perfil')->unsigned();
            $table->bigInteger('id_empresa')->unsigned();
            $table->bigInteger('id_linha_produto')->unsigned();

            $table->foreign('id_perfil')->references('id_perfil')->on('perfil')->onDelete('cascade');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa')->onDelete('cascade');
            $table->foreign('id_linha_produto')->references('id_linha_produto')->on('linha_produto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
