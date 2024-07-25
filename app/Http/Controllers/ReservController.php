<?php

namespace App\Http\Controllers;

use App\Models\Reserv;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;
use App\Http\Requests\ReservReservRequest;
use App\Models\Event;

class ReservController extends Controller
{
    public function show($id)
    {
        $reservsDB = Reserv::where('event_id', $id)->get()->keyBy('table');

        $reservs = [];
        foreach (ReservTablesEnum::cases() as $table) {

            $tableDB = $reservsDB->get($table->value);

            if ($tableDB) {
                $status = ReservStatusEnum::from($tableDB->status);
            }

            $reservs[$table->value] = [
                'name' => $table->toString(),
                'price' => $table->price(),
                'color' => $tableDB ? $status->getColorNotFree() : $table->color(),
                'status' => $tableDB ? $status->value : ReservStatusEnum::FREE->value
            ];
        }

        return $reservs;
    }

    public function reserv(ReservReservRequest $request)
    {
        $reserv = Reserv::create([
            ...$request->validated(),
            'status' => ReservStatusEnum::PENDING->value
        ]);

        return response('ok');
    }

    public function confirm(Reserv $reserv)
    {

        return response('ok');
    }

    public function cancel(Reserv $reserv)
    {


        return response('ok');
    }
}
