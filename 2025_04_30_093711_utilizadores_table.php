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
    Schema::create('utilizadores', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('telefone');
        $table->string('email')->unique();
        $table->string('palavra_passe');
        $table->enum('tipo', ['administrador', 'comum'])->default('comum');
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('utilizadores');
    }
};
