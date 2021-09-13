<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEventosHistorico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos_historico', function (Blueprint $table) {
            $table->id();
            $table->integer('id_evento');
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('id_usuario');
            $table->integer('empresa');
            $table->char('status', 1);
            $table->integer('tipo_trabalho');
            $table->integer('id_creator');
            $table->char('tipo_data', 1);
            $table->char('tipo_periodo', 1);
            $table->softDeletes($column = 'deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos_historico');
    }
}
