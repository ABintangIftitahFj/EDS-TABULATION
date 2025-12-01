<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdjudicatorReview;
use App\Models\DebateMatch;
use App\Models\Adjudicator;
use Illuminate\Http\Request;

class AdjudicatorReviewController extends Controller
{
    public function store(Request $request, DebateMatch $match)
    {
        $validated = $request->validate([
            'adjudicator_id' => 'required|exists:adjudicators,id',
            'rating' => 'required|integer|min:1|max:5',
            'score_team_a' => 'nullable|numeric|min:0|max:100',
            'score_team_b' => 'nullable|numeric|min:0|max:100',
            'comment' => 'nullable|string|max:1000',
        ]);

        $adjudicator = Adjudicator::findOrFail($validated['adjudicator_id']);

        // Create feedback record (user_id may be null for anonymous public submissions)
        \App\Models\AdjudicatorFeedback::create([
            'adjudicator_id' => $validated['adjudicator_id'],
            'user_id' => auth()->id() ?? null,
            'match_id' => $match->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Recalculate average rating
        $avgRating = \App\Models\AdjudicatorFeedback::where('adjudicator_id', $adjudicator->id)
            ->avg('rating');
        $adjudicator->update(['rating' => round($avgRating, 2)]);

        // If scores provided, create review
        if (isset($validated['score_team_a']) && isset($validated['score_team_b'])) {
            $existing = AdjudicatorReview::where('match_id', $match->id)
                ->where('adjudicator_id', $validated['adjudicator_id'])
                ->first();

            if (!$existing) {
                AdjudicatorReview::create([
                    'match_id' => $match->id,
                    'adjudicator_id' => $validated['adjudicator_id'],
                    'score_team_a' => $validated['score_team_a'],
                    'score_team_b' => $validated['score_team_b'],
                    'comment' => $validated['comment'] ?? null,
                ]);

                // Update adjudicator stats
                $adjudicator->increment('total_matches_judged');

                // Calculate final scores if all reviews are in
                if (method_exists($match, 'calculateFinalScores')) {
                    $match->calculateFinalScores();
                }
            }
        }

        return back()->with('success', 'Thank you — your review was submitted.');
    }
}
