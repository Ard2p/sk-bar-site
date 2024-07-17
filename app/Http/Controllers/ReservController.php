<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reserv;
use App\Enums\ReservTablesEnum;
use App\Enums\ReservStatusEnum;

class ReservController extends Controller
{
    public function show($id)
    {
        // $reserves = Reserv::where('event_id', $id)->get();
        $reserves = [];
        foreach (ReservTablesEnum::cases() as $table) {
            $reserves[$table->value] = [
                'table' => $table->toString(),
                'price' => $table->price(),
                'color' => $table->color(),
                'status' => ReservStatusEnum::FREE->value
            ];
        }

        return $reserves;
    }
}
