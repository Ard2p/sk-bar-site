<?php

namespace App\Enums;

enum AgeLimitEnum: string
{
    case AGE_0 = '0';
    case AGE_6 = '6';
    case AGE_12 = '12';
    case AGE_16 = '16';
    case AGE_18 = '18';

    public function toString(): ?string
    {
        return match ($this) {
            self::AGE_0 => '0+',
            self::AGE_6 => '6+',
            self::AGE_12 => '12+',
            self::AGE_16 => '16+',
            self::AGE_18 => '18+',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::AGE_0 => 'success',
            self::AGE_6 => 'info',
            self::AGE_12 => 'warning',
            self::AGE_16 => 'secondary',
            self::AGE_18 => 'error',
        };
    }
}
