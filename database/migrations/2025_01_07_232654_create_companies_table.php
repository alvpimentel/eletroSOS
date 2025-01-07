<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); 
            $table->string('nome'); 
            $table->text('description')->nullable(); 
            $table->string('identifier')->unique()->nullable(); 
            $table->string('contact_email')->nullable(); 
            $table->string('contact_phone')->nullable(); 
            $table->text('address')->nullable(); 
            $table->boolean('status')->default(true); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
