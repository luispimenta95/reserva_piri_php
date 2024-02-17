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
        Schema::create('hospedes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('nascimento');
            $table->string('cpf');
            $table->string('email');
            $table->string('telefone');
            $table->timestamp('data_criacao')->useCurrent();
            $table->timestamp('ultima_atualizacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospedes');
    }
};
