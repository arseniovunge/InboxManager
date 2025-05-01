<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('emails', function (Blueprint $table) {
        $table->id();
        $table->foreignId('utilizador_id')->constrained('utilizadores')->onDelete('cascade');
        $table->string('remetente');
        $table->string('assunto');
        $table->text('corpo');
        $table->timestamp('recebido_em');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
