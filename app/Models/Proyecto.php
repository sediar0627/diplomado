<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'creador_id',
        'codigo',
        'nombre',
        'descripcion',
        'incidencias_creadas'
    ];

    protected $cast = [
        'incidencias_creadas' => 'integer',
    ];

    protected $appends = [
        'descripcion_modelo',
    ];

    public function getDescripcionModeloAttribute()
    {
        return $this->codigo . ' - ' . $this->nombre;
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'proyecto_id');
    }

    public function usuariosInvitados(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'proyecto_usuarios')
            ->using(ProyectoUsuario::class);
    }

    public function obtenerNuevoConsecutivoIncidencia()
    {
        $this->incidencias_creadas++;
        $this->save();

        return $this->incidencias_creadas;
    }

    public function sePuedeEliminar(): bool
    {
        return $this->creador_id == auth()->id();
    }
}
