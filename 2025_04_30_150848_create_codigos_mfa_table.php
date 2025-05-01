<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

public function up(): void
{
    Schema::create('codigos_mfa', function (Blueprint $table) {
        $table->id();
        $table->foreignId('utilizador_id')->constrained('utilizadores')->onDelete('cascade');
        $table->string('codigo');
        $table->timestamp('expira_em');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos_mfa');
    }
};
