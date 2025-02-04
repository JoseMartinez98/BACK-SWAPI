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
        Schema::create('nave_personaje', function (Blueprint $table) {
            $table->foreignId('id_naves')->constrained('naves', 'id_naves')->onDelete('cascade');
            $table->foreignId('id_personajes')->constrained('personajes', 'id_personajes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
