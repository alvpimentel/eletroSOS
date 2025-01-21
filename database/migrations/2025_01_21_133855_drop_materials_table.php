<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMaterialsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('materials');
    }

    public function down()
    {
        // Se necessário, você pode criar a tabela novamente aqui.
    }
}
