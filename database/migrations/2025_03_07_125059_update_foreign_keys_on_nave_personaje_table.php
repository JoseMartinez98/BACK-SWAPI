<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('nave_personaje', function (Blueprint $table) {
            $table->dropForeign(['personaje_id']); // Eliminar clave foránea existente
            $table->foreign('personaje_id')
                  ->references('id_personajes')
                  ->on('personajes')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('nave_personaje', function (Blueprint $table) {
            $table->dropForeign(['personaje_id']);
            $table->foreign('personaje_id')
                  ->references('id_personajes')
                  ->on('personajes')
                  ->onDelete('cascade');
        });
    }
};
