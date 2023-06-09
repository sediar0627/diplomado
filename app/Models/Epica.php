<?php

namespace App\Models;

use App\Interface\ContratoModelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Epica extends Model implements ContratoModelo
{
    use HasFactory;

    protected $table = 'epicas';

    protected $fillable = [
        'proyecto_id',
        'nombre',
    ];

    protected $appends = [
        'descripcion_modelo',
    ];

    public function getDescripcionModeloAttribute()
    {
        return $this->nombre;
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'epica_id');
    }
}
