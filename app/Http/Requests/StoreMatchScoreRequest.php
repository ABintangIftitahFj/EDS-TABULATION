<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMatchScoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Should be handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'winner' => ['required', Rule::in(['government', 'opposition'])],
            'adjudicator_id' => 'required|exists:adjudicators,id',
            
            // Government scores
            'gov_scores' => 'required|array|min:1',
            'gov_scores.*.speaker_id' => 'required|exists:speakers,id',
            'gov_scores.*.score' => [
                'required',
                'numeric',
                'min:60', // Minimum score untuk debat
                'max:90', // Maximum score untuk debat
            ],
            'gov_scores.*.feedback' => 'nullable|string|max:1000',
            
            // Opposition scores
            'opp_scores' => 'required|array|min:1',
            'opp_scores.*.speaker_id' => 'required|exists:speakers,id',
            'opp_scores.*.score' => [
                'required',
                'numeric',
                'min:60',
                'max:90',
            ],
            'opp_scores.*.feedback' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'gov_scores.*.score.min' => 'Speaker score must be at least 60 points',
            'gov_scores.*.score.max' => 'Speaker score cannot exceed 90 points',
            'opp_scores.*.score.min' => 'Speaker score must be at least 60 points',
            'opp_scores.*.score.max' => 'Speaker score cannot exceed 90 points',
            'winner.in' => 'Winner must be either government or opposition',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation: Check score margin
            if ($this->has('gov_scores') && $this->has('opp_scores')) {
                $govTotal = collect($this->gov_scores)->sum('score');
                $oppTotal = collect($this->opp_scores)->sum('score');
                $margin = abs($govTotal - $oppTotal);
                
                // Check if winner matches score totals
                $declaredWinner = $this->winner;
                $actualWinner = $govTotal > $oppTotal ? 'government' : 'opposition';
                
                if ($declaredWinner !== $actualWinner && $govTotal !== $oppTotal) {
                    $validator->errors()->add(
                        'winner',
                        'Declared winner does not match score totals. Gov: ' . $govTotal . ', Opp: ' . $oppTotal
                    );
                }
                
                // Warning for very close margins (optional)
                if ($margin < 5 && $margin > 0) {
                    \Log::warning("Very close match result: Margin of {$margin} points");
                }
            }
            
            // Check that all speakers from gov team are included
            // Check that all speakers from opp team are included
            // This can be added based on your business rules
        });
    }
}
