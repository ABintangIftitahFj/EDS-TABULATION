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
            'score_team_a' => 'required|numeric|min:0|max:100',
            'score_team_b' => 'required|numeric|min:0|max:100',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if this adjudicator already reviewed this match
        $existing = AdjudicatorReview::where('match_id', $match->id)
            ->where('adjudicator_id', $validated['adjudicator_id'])
            ->first();

        if ($existing) {
            return back()->withErrors(['adjudicator_id' => 'This adjudicator has already reviewed this match.']);
        }

        $review = AdjudicatorReview::create([
            'match_id' => $match->id,
            'adjudicator_id' => $validated['adjudicator_id'],
            'score_team_a' => $validated['score_team_a'],
            'score_team_b' => $validated['score_team_b'],
            'comment' => $validated['comment'],
        ]);

        // Update adjudicator stats
        $adjudicator = Adjudicator::find($validated['adjudicator_id']);
        $adjudicator->increment('total_matches_judged');

        // Recalculate average score
        $avgScore = AdjudicatorReview::where('adjudicator_id', $adjudicator->id)
            ->selectRaw('AVG((score_team_a + score_team_b) / 2) as avg')
            ->first()
            ->avg;
        $adjudicator->update(['average_score_given' => $avgScore]);

        // Calculate final scores if all reviews are in
        $match->calculateFinalScores();

        return redirect()
            ->route('admin.adjudicator-reviews.create', $match)
            ->with('success', 'Review submitted successfully!');
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
