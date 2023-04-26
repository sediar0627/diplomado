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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Sprint::class, 'sprint_id')->nullable()->constrained('sprints');
            $table->integer('consecutivo');
            $table->string('titulo', 100);
            $table->text('descripcion')->nullable();
            $table->foreignIdFor(App\Models\Epica::class)->nullable()->constrained('epicas');
            $table->integer('puntaje')->nullable();
            $table->string('estado', 20)->default(App\Enums\EstadoIncidencia::PENDIENTE->value);
            $table->foreignIdFor(\App\Models\Usuario::class, 'responsable_id')->nullable()->constrained('usuarios');
            $table->foreignIdFor(\App\Models\Usuario::class, 'informador_id')->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
