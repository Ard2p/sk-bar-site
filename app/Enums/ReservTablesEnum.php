<?php

namespace App\Enums;

enum ReservTablesEnum: string
{
    case TABLE_1 = '1';
    case TABLE_2 = '2';
    case TABLE_3 = '3';
    case TABLE_4 = '4';
    case TABLE_5 = '5';
    case TABLE_6 = '6';
    case TABLE_7 = '7';
    case TABLE_8 = '8';
    case TABLE_9 = '9';
    case TABLE_10 = '10';
    case TABLE_11 = '11';
    case TABLE_12 = '12';
    case TABLE_13 = '13';
    case TABLE_14 = '14';
    case TABLE_15 = '15';
    case TABLE_101 = '101';
    case TABLE_102 = '102';
    case TABLE_103 = '103';
    case TABLE_104 = '104';
    case TABLE_105 = '105';
    case TABLE_106 = '106';
    case TABLE_107 = '107';

    public function toString(): ?string
    {
        return match ($this) {
            self::TABLE_1 => '1',
            self::TABLE_2 => '2',
            self::TABLE_3 => '3',
            self::TABLE_4 => '4',
            self::TABLE_5 => '5',
            self::TABLE_6 => '6',
            self::TABLE_7 => '7',
            self::TABLE_8 => '8',
            self::TABLE_9 => '9',
            self::TABLE_10 => '10',
            self::TABLE_11 => '11',
            self::TABLE_12 => '12',
            self::TABLE_13 => '13',
            self::TABLE_14 => '14',
            self::TABLE_15 => '15',
            self::TABLE_101 => '101',
            self::TABLE_102 => '102',
            self::TABLE_103 => '103',
            self::TABLE_104 => '104',
            self::TABLE_105 => '105',
            self::TABLE_106 => '106',
            self::TABLE_107 => '107',
        };
    }
}
