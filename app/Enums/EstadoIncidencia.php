<?php

namespace App\Enums;

use App\Enums\Contratos\EnumContracto;

/**
 * Estados de una incidencia.
 */
enum EstadoIncidencia : string implements EnumContracto
{
    case PENDIENTE = 'PENDIENTE';
    case EN_CURSO = 'EN_CURSO';
    case AJUSTES = 'AJUSTE';
    case QA = 'QA';
    case FINALIZADA = 'FINALIZADA';

    public function descripcion(): string
    {
        return match ($this) {
            self::PENDIENTE => 'PENDIENTE',
            self::EN_CURSO => 'EN CURSO',
            self::AJUSTES => 'AJUSTES',
            self::QA => 'QA',
            self::FINALIZADA => 'FINALIZADA',
        };
    }
}
