<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->renameColumn('idUsuario', 'company_id');
            
            $table->decimal('valor', 10, 2)->nullable(); 
        });
    }

    /**
     * Reversing the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->renameColumn('company_id', 'idUsuario');
            
            $table->dropColumn('valor');
        });
    }
}
