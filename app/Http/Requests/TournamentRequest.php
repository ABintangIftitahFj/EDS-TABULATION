<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:tournaments,slug',
            'format' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'location' => 'nullable|string',
            'status' => 'in:upcoming,ongoing,completed,draft',
            'is_public' => 'boolean',
            'settings' => 'nullable|array',
        ];
    }
}
