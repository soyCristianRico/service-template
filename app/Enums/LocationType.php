<?php

declare(strict_types=1);

namespace App\Enums;

enum LocationType: string
{
    case Country = 'country';
    case Region = 'region';
    case Province = 'province';
    case City = 'city';
    case District = 'district';

    public function label(): string
    {
        return match ($this) {
            self::Country => 'País',
            self::Region => 'Comunidad / Región',
            self::Province => 'Provincia',
            self::City => 'Ciudad',
            self::District => 'Distrito / Barrio',
        };
    }
}
