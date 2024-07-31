<?php

namespace App\Http\Handlers;

use App\Models\Reserv;
use SergiX44\Nutgram\Nutgram;
use App\Enums\ReservStatusEnum;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class ReservHandler
{

    public static function reserv(Nutgram $bot, Reserv $reserv)
    {
        $template = (string)view('reservs.telegram.admin', [
            'status' => __('⚠️ Ожидает подтверждения'),
            'table' => $reserv->table,
            'name' => $reserv->name,
            'phone' => $reserv->phone,
            'seats' => $reserv->seats
        ]);

        $bot->sendMessage(
            $template,
            config('nutgram.reserv_group'),
            parse_mode: 'HTML',
            reply_markup: InlineKeyboardMarkup::make()->addRow(
                InlineKeyboardButton::make(__('✅ Подтвердить'), callback_data: 'confirm:' . $reserv->id),
                InlineKeyboardButton::make(__('❌ Отменить'), callback_data: 'cancel:' . $reserv->id)
            )
        );
    }

    public static function confirm(Nutgram $bot, $reservId)
    {
        $reserv = Reserv::find($reservId);

        $template = (string)view('reservs.telegram.admin', [
            'status' => __('✅ Бронь подтверждена'),
            'table' => $reserv->table,
            'name' => $reserv->name,
            'phone' => $reserv->phone,
            'seats' => $reserv->seats
        ]);

        $otherReserv = Reserv::where('event_id', $reserv->event_id)->where('table', $reserv->table)->whereNot('id', $reservId)->get();
        if (!count($otherReserv)) {
            $reserv->status = ReservStatusEnum::RESERV->value;
            $reserv->save();

            $bot->editMessageText(
                $template,
                parse_mode: ParseMode::HTML,
                reply_markup: InlineKeyboardMarkup::make()->addRow(
                    InlineKeyboardButton::make(__('❌ Отменить'), callback_data: 'cancel:' . $reserv->id)
                )
            );
        }
    }

    public static function cancel(Nutgram $bot, $reservId)
    {
        $reserv = Reserv::find($reservId);

        $template = (string)view('reservs.telegram.admin', [
            'status' => __('❌ Бронь отменена'),
            'table' => $reserv->table,
            'name' => $reserv->name,
            'phone' => $reserv->phone,
            'seats' => $reserv->seats
        ]);

        $reserv->delete();

        $bot->editMessageText(
            $template,
            parse_mode: ParseMode::HTML
        );
    }
}
