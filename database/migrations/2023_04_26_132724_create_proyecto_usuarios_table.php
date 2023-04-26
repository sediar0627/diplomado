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
        Schema::create('proyecto_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Proyecto::class)->constrained('proyectos');
            $table->foreignIdFor(\App\Models\Usuario::class)->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_usuarios');
    }
};
