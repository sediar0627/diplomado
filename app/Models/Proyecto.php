<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'creador_id',
        'codigo',
        'nombre',
        'descripcion',
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

    public function puedeEliminar(): bool
    {
        return $this->creador_id == auth()->id();
    }
}
