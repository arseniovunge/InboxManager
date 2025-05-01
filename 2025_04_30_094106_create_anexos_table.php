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
    Schema::create('anexos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('email_id')->constrained('emails')->onDelete('cascade');
        $table->string('nome_ficheiro');
        $table->string('tipo_ficheiro');
        $table->string('caminho');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexos');
    }
};
