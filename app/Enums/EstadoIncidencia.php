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
    case TEST = 'TEST';
    case QA = 'QA';
    case FINALIZADA = 'FINALIZADA';

    public function descripcion(): string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::EN_CURSO => 'En curso',
            self::AJUSTES => 'Ajustes',
            self::TEST => 'Test',
            self::QA => 'QA',
            self::FINALIZADA => 'Finalizada',
        };
    }
}
