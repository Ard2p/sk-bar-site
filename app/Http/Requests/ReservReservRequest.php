<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class ReservReservRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // dd($this->phone);
        return [
            'event_id' => 'required|exists:events,id',
            'table' => [
                'required',
                // Rule::unique('users')->where(fn (Builder $query) => $query->where('account_id', 1))
            ],
            'name' => 'required|string',
            'phone' => 'required|string',
        ];
    }
}

//  'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9'
