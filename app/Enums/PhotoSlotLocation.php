<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PhotoSlotLocation: string implements HasLabel
{
    case Atelier = 'atelier';
    case Exterior = 'exterior';
    case Custom = 'custom';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Atelier => 'Ateliér',
            self::Exterior => 'Exteriér',
            self::Custom => 'Dle domluvy',
        };
    }
}
