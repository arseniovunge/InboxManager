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
    Schema::table('emails', function (Blueprint $table) {
        $table->enum('tipo', ['recebido', 'enviado'])->default('recebido')->after('utilizador_id');
    });
}

public function down(): void
{
    Schema::table('emails', function (Blueprint $table) {
        $table->dropColumn('tipo');
    });
}

};
