<?php

namespace App\Http\Requests\Evens;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function rules(): array
    {


        return [
            'event_category_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'text' => ['required'],
            'photo' => ['required'],
            'ticket_amount' => ['nullable', 'integer'],
            'ticket_count' => ['nullable', 'integer'],
            'show_ticket_count' => ['nullable'],
            'free_entrance' => ['nullable'],
            'event_type' => ['required'],
            'event_schedules' => ['array'],
            'event_schedules.*.title' => ['string', 'nullable'],
            'event_schedules.*.start_date' => ['string', 'required'],
            'event_schedules.*.start_time' => ['string', 'required'],
            'event_schedules.*.end_date' => ['string', 'required'],
            'event_schedules.*.end_time' => ['string', 'required'],
            'phones' => ['array'],
            'sites' => ['array'],
            'organizer' => ['string', 'nullable'],
            'address' => ['string', 'nullable'],

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
