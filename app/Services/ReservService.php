<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Reserv;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;

class ReservService
{
    public function show(Event $event, $isAdmim = false)
    {
        $reservsDB = Reserv::where('event_id', $event->id)->get()->keyBy('table');

        $reservs = [];
        foreach (ReservTablesEnum::cases() as $table) {

            $reservs[$table->value] = [
                'name' => $table->toString(),
                'price' => $table->price(),
                'color' => $table->color(),
                'status' => ReservStatusEnum::FREE->value,
                'fio' => null,
                'seats' => null,
                'phone' => null,
            ];

            $tableDB = $reservsDB->get($table->value);

            if ($tableDB) {
                $status = ReservStatusEnum::from($tableDB->status);
                $statusRemoved = $status == ReservStatusEnum::REMOVED;

                $reservs[$table->value] = array_merge($reservs[$table->value], [
                    'color' => $isAdmim ? $status->getColor() : $status->getColorNotFree(),
                    'status' => $status->value,
                ]);

                if ($isAdmim) {
                    $reservs[$table->value] = array_merge($reservs[$table->value], [
                        'id' => $tableDB->id,
                        'fio' => !$statusRemoved ? $tableDB->name : null,
                        'seats' => !$statusRemoved ? $tableDB->seats ?: null : null,
                        'phone' => !$statusRemoved ? $tableDB->phone : null,
                    ]);
                }
            }
            // $reservs[$table->value] = collect($reservs[$table->value]);
        }

        return collect($reservs);
    }
}
