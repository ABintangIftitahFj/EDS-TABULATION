<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Services\TabulationService;

class BreakController extends Controller
{
    public function index($tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);
        $breakCount = request('break_count', 8);
        $breakList = (new TabulationService())->getBreakList($tournament, $breakCount);
        return response()->json($breakList);
    }
}
