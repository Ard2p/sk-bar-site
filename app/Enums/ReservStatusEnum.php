<?php

namespace App\Enums;

enum ReservStatusEnum: string
{
    case FREE = 'free';
    case PENDING = 'pending';
    case RESERV = 'reserv';

    public function toString(): ?string
    {
        return match ($this) {
            self::FREE => 'Свободен',
            self::PENDING => 'Ожидает подтверждения',
            self::RESERV => 'Зарезервирован',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::FREE => 'white',
            self::PENDING => 'yellow',
            self::RESERV => 'red',
        };
    }

    public function getColorNotFree(): ?string
    {
        return match ($this) {
            self::FREE => null,
            self::PENDING => 'yellow',
            self::RESERV => 'white'
        };
    }
}
