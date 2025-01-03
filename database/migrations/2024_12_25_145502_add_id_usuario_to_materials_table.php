<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUsuarioToMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('idUsuario')
                  ->constrained('users') 
                  ->onDelete('cascade')
                  ->after('id'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['idUsuario']);
            $table->dropColumn('idUsuario');
        });
    }
}
