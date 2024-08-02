<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reserv;
use SergiX44\Nutgram\Nutgram;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;
use App\Http\Handlers\ReservHandler;
use App\Http\Requests\ReservStoreRequest;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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

    public function reserv(ReservStoreRequest $request, Nutgram $bot)
    {
        $reserv = Reserv::create([
            ...$request->validated(),
            'status' => ReservStatusEnum::PENDING->value
        ]);

        ReservHandler::reserv($bot, $reserv);

        return response('ok');
    }
}
