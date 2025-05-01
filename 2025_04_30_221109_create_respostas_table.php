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
    Schema::create('respostas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('email_id')->constrained('emails')->onDelete('cascade');
        $table->foreignId('utilizador_id')->constrained('utilizadores')->onDelete('cascade');
        $table->text('mensagem');
        $table->timestamp('respondido_em')->useCurrent();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostas');
    }
};
