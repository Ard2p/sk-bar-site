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
        $bot->sendMessage(
            self::templateBuilder($reserv, __('⚠️ Ожидает подтверждения')),
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
        $reserv = Reserv::with('event')->find($reservId);

        $otherReserv = Reserv::where('event_id', $reserv->event_id)->where('table', $reserv->table)->whereNot('id', $reservId)->get();
        if (!count($otherReserv)) {
            $reserv->status = ReservStatusEnum::RESERV->value;
            $reserv->save();

            $bot->editMessageText(
                self::templateBuilder($reserv, __('✅ Бронь подтверждена')),
                parse_mode: ParseMode::HTML,
                reply_markup: InlineKeyboardMarkup::make()->addRow(
                    InlineKeyboardButton::make(__('❌ Отменить'), callback_data: 'cancel:' . $reserv->id)
                )
            );
        }
    }

    public static function cancel(Nutgram $bot, $reservId)
    {
        $reserv = Reserv::with('event')->find($reservId);

        $reserv->delete();

        $bot->editMessageText(
            self::templateBuilder($reserv, __('❌ Бронь отменена')),
            parse_mode: ParseMode::HTML
        );
    }

    public static function templateBuilder($reserv, $status)
    {
        return (string)view('reservs.telegram.admin', [
            'status' => $status,
            'table' => $reserv->table,
            'name' => $reserv->name,
            'phone' => preg_replace('/[^0-9+]/', '', $reserv->phone),
            'seats' => $reserv->seats,
            'event' => $reserv->event->name,
            'date' => $reserv->event->guest_start->format('d.m'),
        ]);
    }
}
