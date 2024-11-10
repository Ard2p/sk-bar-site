<?php

namespace App\Enums;

enum TicketsTypetEnum: string
{
    case QTICKETS = 'qtickets';
    case TICKETSCLOUD = 'ticketscloud';

    public function toString(): ?string
    {
        return match ($this) {
            self::QTICKETS => 'Qtickets',
            self::TICKETSCLOUD => 'Ticketscloud',
        };
    }
}
