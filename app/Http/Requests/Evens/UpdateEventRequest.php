<?php

namespace App\Http\Requests\Evens;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_category_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
            'text' => ['required'],
            'photo' => ['required'],
            'address' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
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
            'city' => ['required'],
            'country' => ['required'],
            'phones' => ['array'],
            'phones.*' => ['string', 'nullable'],
            'sites' => ['array'],
            'sites.*' => ['string', 'nullable'],
            'organizer' => ['string', 'nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
