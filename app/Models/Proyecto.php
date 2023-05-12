<?php

namespace App\Models;

use App\Enums\EstadoIncidencia;
use App\Interface\ContratoModelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model implements ContratoModelo
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

    public function epicas(): HasMany
    {
        return $this->hasMany(Epica::class, 'proyecto_id');
    }

    public function incidencias(EstadoIncidencia $estado = null): HasMany
    {
        $query = $this->hasMany(Incidencia::class, 'proyecto_id');

        if ($estado) {
            $query->where('estado', $estado);
        }

        return $query;
    }

    public function usuariosInvitados(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'proyecto_usuarios')
            ->using(ProyectoUsuario::class);
    }

    public function cantidadIncidenciasPorEstado(): array
    {
        $estadosIncidencias = $this->incidencias()
            ->selectRaw('estado, count(*) as cantidad')
            ->groupBy('estado')
            ->pluck('cantidad', 'estado')
            ->toArray();

        $incidenciasPorEstado = [];

        foreach (EstadoIncidencia::cases() as $estado) {
            if (array_key_exists($estado->value, $estadosIncidencias)) {
                $incidenciasPorEstado[$estado->value] = $estadosIncidencias[$estado->value];
            } else {
                $incidenciasPorEstado[$estado->value] = 0;
            }
        }

        return $incidenciasPorEstado;
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
