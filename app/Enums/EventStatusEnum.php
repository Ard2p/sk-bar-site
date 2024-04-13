<?php

namespace App\Enums;

enum EventStatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLIC = 'publish';

    public function toString(): ?string
    {
        return match ($this) {
            self::DRAFT => 'Черновик',
            self::PUBLIC => 'Опубликован',
        };
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PUBLIC => 'success',
        };
    }
}
