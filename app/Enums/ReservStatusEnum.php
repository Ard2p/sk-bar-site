<?php

namespace App\Enums;

enum ReservStatusEnum: string
{
    case FREE = 'free';
    case PENDING = 'pending';
    case RESERV = 'reserv';
    case REMOVED = 'removed';

    public function toString(): ?string
    {
        return match ($this) {
            self::FREE => 'Свободен',
            self::PENDING => 'Ожидает подтверждения',
            self::RESERV => 'Зарезервирован',
            self::REMOVED => 'Убран',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::FREE => 'white',
            self::PENDING => 'yellow',
            self::RESERV => 'red',
            self::REMOVED => 'black',
        };
    }

    public function getColorAdmin(): ?string
    {
        return match ($this) {
            self::FREE => null,
            self::PENDING => 'yellow',
            self::RESERV => 'red',
            self::REMOVED => 'black',
        };
    }

    public function getColorNotFree(): ?string
    {
        return match ($this) {
            self::FREE => 'white',
            self::PENDING => 'white',
            self::RESERV => 'white',
            self::REMOVED => 'black',
        };
    }
}
