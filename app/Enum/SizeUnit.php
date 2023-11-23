<?php

namespace App\Enum;

enum SizeUnit: string
{
    case Gram = 'g';
    case Kilogram = 'kg';
    case Liter = 'l';
    case Mililiter = 'ml';
    case Piece = 'pcs';

    public function fullUnitName(): string
    {
        return match ($this) {
            self::Gram => 'gram',
            self::Kilogram => 'kilogram',
            self::Liter => 'liter',
            self::Mililiter => 'mililiter',
            self::Piece => 'piece',
        };
    }
}
