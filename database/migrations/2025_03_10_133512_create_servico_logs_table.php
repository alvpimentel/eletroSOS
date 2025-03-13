<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicoLogsTable extends Migration
{
    public function up()
    {
        Schema::create('servico_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servico_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('tx_alteracoes'); 
            $table->json('json_detalhes')->nullable();
            $table->string('tx_ip', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servico_logs');
    }
}