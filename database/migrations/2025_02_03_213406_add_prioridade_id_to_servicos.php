<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->foreignId('prioridade_id')->nullable()->constrained('prioridades')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->dropForeign(['prioridade_id']);
            $table->dropColumn('prioridade_id');
        });
    }
};

