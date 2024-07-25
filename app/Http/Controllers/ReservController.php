<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reserv;
use SergiX44\Nutgram\Nutgram;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;
use App\Http\Requests\ReservReservRequest;

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

    public function reserv(ReservReservRequest $request, Nutgram $bot)
    {
        $reserv = Reserv::create([
            ...$request->validated(),
            'status' => ReservStatusEnum::PENDING->value
        ]);

        $bot->sendMessage(
            $request->validated()['table'],
            config('nutgram.reserv_group'),
            parse_mode: 'HTML'
        );

        // $bot->sendMessage((string)view('telegram.admin.message.details', [
        //     'id' => $bot->user()->id,
        //     'firstName' => $bot->user()->first_name,
        //     'lastName' => $bot->user()->last_name,
        //     'username' => $bot->user()->username ?? $bot->user()->first_name
        // ]), config('nutgram.admin_group'), parse_mode: 'HTML');

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
