<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;
use App\Http\Controllers\ReservController;
use App\Http\Handlers\ReservHandler;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/
// Nutgram $bot,
$bot->onCallbackQueryData('confirm:{reserv}', function (Nutgram $bot, $reserv) {
    ReservHandler::confirm($bot, $reserv);
});

$bot->onCallbackQueryData('cancel:{reserv}', function (Nutgram $bot, $reserv) {
    ReservHandler::cancel($bot, $reserv);
});
