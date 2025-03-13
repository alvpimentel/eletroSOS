<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTecnicoIdToServicosTable extends Migration
{
    public function up()
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->unsignedBigInteger('tecnico_id')->nullable();

            $table->foreign('tecnico_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); 
        });
    }

    public function down()
    {
        Schema::table('servicos', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['tecnico_id']);

            // Remove a coluna tecnico_id
            $table->dropColumn('tecnico_id');
        });
    }
}
