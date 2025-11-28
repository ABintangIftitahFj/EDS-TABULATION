// Break list endpoint
Route::get('tournaments/{tournament}/break', [\App\Http\Controllers\API\BreakController::class, 'index']);
// CSV Import endpoints
Route::post('import/teams', [\App\Http\Controllers\API\ImportController::class, 'importTeams']);
Route::post('import/adjudicators', [\App\Http\Controllers\API\ImportController::class, 'importAdjudicators']);
Route::post('import/rooms', [\App\Http\Controllers\API\ImportController::class, 'importRooms']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TournamentController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\RoundController;
use App\Http\Controllers\API\MatchController;
use App\Http\Controllers\API\BallotController;
use App\Http\Controllers\API\AdjudicatorController;
use App\Http\Controllers\API\RoomController;

Route::apiResource('tournaments', TournamentController::class);
Route::apiResource('teams', TeamController::class);
Route::apiResource('rounds', RoundController::class);
Route::apiResource('matches', MatchController::class);
Route::apiResource('adjudicators', AdjudicatorController::class);
Route::apiResource('rooms', RoomController::class);

// Ballot endpoints
Route::get('matches/{match}/ballots', [BallotController::class, 'index']);
Route::post('matches/{match}/ballots', [BallotController::class, 'store']);
Route::get('ballots/{ballot}', [BallotController::class, 'show']);
Route::get('matches/{match}/consensus', [BallotController::class, 'consensus']);

// Check-in endpoints
Route::patch('teams/{team}/checkin', function($teamId) {
	$team = \App\Models\Team::findOrFail($teamId);
	$team->is_present = true;
	$team->save();
	return response()->json(['message' => 'Team checked in']);
});
Route::patch('adjudicators/{adjudicator}/checkin', function($adjudicatorId) {
	$adj = \App\Models\Adjudicator::findOrFail($adjudicatorId);
	$adj->is_present = true;
	$adj->save();
	return response()->json(['message' => 'Adjudicator checked in']);
});

// Adjudicator feedback endpoints
Route::get('adjudicators/{adjudicator}/feedback', [\App\Http\Controllers\API\AdjudicatorFeedbackController::class, 'index']);
Route::post('adjudicators/{adjudicator}/feedback', [\App\Http\Controllers\API\AdjudicatorFeedbackController::class, 'store']);
