<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::table('personajes', function (Blueprint $table) {
            $table->string('birth_year', 20)->nullable(); 
            $table->string('height', 20)->nullable(); 
            $table->string('mass', 20)->nullable(); 
        });
    }

 
    public function down(): void
    {
        
    }
};
