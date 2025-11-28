<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdjudicatorFeedback;
use Illuminate\Http\Request;

class AdjudicatorFeedbackController extends Controller
{
    public function index($adjudicatorId)
    {
        $feedback = AdjudicatorFeedback::where('adjudicator_id', $adjudicatorId)->with(['user', 'match'])->get();
        return response()->json($feedback);
    }

    public function store(Request $request, $adjudicatorId)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'match_id' => 'required|exists:matches,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $data['adjudicator_id'] = $adjudicatorId;
        $feedback = AdjudicatorFeedback::create($data);
        return response()->json($feedback, 201);
    }
}
