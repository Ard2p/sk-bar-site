<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class ReservStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'phone' => 'required|string',
            'seats' => 'required|numeric|min:1',
            'table' => [
                'required',
                Rule::unique('reservs', 'table')->where('event_id', $this->event_id)
            ],
        ];
    }

    //TODO: Сообщения ошибок, сделать понятными
}
