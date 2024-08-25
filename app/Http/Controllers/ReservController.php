<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reserv;
use SergiX44\Nutgram\Nutgram;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;
use App\Services\ReservService;
use App\Http\Handlers\ReservHandler;
use App\Http\Requests\ReservStoreRequest;

class ReservController extends Controller
{
    public function __construct(protected ReservService $reservService) {}

    public function show($id)
    {
        $event = Event::find($id);
        $reservs = $this->reservService->show($event);

        return $reservs;
    }

    public function print(Event $event)
    {
        $reservs = $this->reservService->show($event, true);

        return view('reservs.print', [
            'event' => $event,
            'reservs' => $reservs
        ]);
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
