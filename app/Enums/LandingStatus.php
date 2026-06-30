<?php

declare(strict_types=1);

namespace App\Enums;

enum LandingStatus: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Borrador',
            self::Scheduled => 'Programada',
            self::Published => 'Publicada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'zinc',
            self::Scheduled => 'amber',
            self::Published => 'green',
        };
    }
}
