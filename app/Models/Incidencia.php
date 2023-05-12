<?php

namespace App\Models;

use App\Enums\EstadoIncidencia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'proyecto_id',
        'sprint_id',
        'consecutivo',
        'titulo',
        'descripcion',
        'epica_id',
        'puntaje',
        'estado',
        'responsable_id',
        'informador_id',
    ];

    protected $casts = [
        'puntaje' => 'integer',
        'estado' => EstadoIncidencia::class,
    ];

    protected $appends = [
        'descripcion_modelo',
    ];

    protected static function booted()
    {
        self::creating(function($incidencia){
            $incidencia->consecutivo = $incidencia->proyecto->obtenerNuevoConsecutivoIncidencia();
        });
    }

    public function getDescripcionModeloAttribute()
    {
        return $this->consecutivo . $this->titulo ? ' - ' . $this->titulo : '';
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class, 'sprint_id');
    }

    public function epica(): BelongsTo
    {
        return $this->belongsTo(Epica::class, 'epica_id');
    }

    public function informador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'informador_id');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
