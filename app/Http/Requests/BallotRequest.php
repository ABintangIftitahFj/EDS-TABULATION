<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BallotRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ballots' => 'required|array',
            'ballots.*.adjudicator_id' => 'required|exists:adjudicators,id',
            'ballots.*.speaker_id' => 'required|exists:speakers,id',
            'ballots.*.score' => 'required|integer|min:60|max:100',
            'ballots.*.team_role' => 'required|in:gov,opp',
            'ballots.*.position' => 'required|string',
            'ballots.*.is_reply' => 'boolean',
            'ballots.*.feedback' => 'nullable|string',
        ];
    }
}
