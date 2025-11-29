<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdjudicatorReview;
use App\Models\DebateMatch;
use App\Models\Adjudicator;
use Illuminate\Http\Request;

class AdjudicatorReviewController extends Controller
{
    public function create(DebateMatch $match)
    {
        $adjudicators = Adjudicator::where('tournament_id', $match->round->tournament_id)->get();
        $existingReviews = $match->adjudicatorReviews()->with('adjudicator')->get();

        return view('admin.adjudicator-reviews.create', compact('match', 'adjudicators', 'existingReviews'));
    }

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

        // Create feedback record
        \App\Models\AdjudicatorFeedback::create([
            'adjudicator_id' => $validated['adjudicator_id'],
            'user_id' => auth()->id(),
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
            // Check if this adjudicator already reviewed this match
            $existing = AdjudicatorReview::where('match_id', $match->id)
                ->where('adjudicator_id', $validated['adjudicator_id'])
                ->first();

            if (!$existing) {
                AdjudicatorReview::create([
                    'match_id' => $match->id,
                    'adjudicator_id' => $validated['adjudicator_id'],
                    'score_team_a' => $validated['score_team_a'],
                    'score_team_b' => $validated['score_team_b'],
                    'comment' => $validated['comment'],
                ]);

                // Update adjudicator stats
                $adjudicator->increment('total_matches_judged');

                // Calculate final scores if all reviews are in
                $match->calculateFinalScores();
            }
        }

        return back()->with('success', 'Review submitted successfully! Adjudicator rating updated to ' . round($avgRating, 2) . '/5');
    }

    public function destroy(AdjudicatorReview $review)
    {
        $matchId = $review->match_id;
        $review->delete();

        return redirect()
            ->route('admin.adjudicator-reviews.create', $matchId)
            ->with('success', 'Review deleted successfully.');
    }
}
