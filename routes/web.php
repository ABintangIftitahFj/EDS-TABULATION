<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public Routes
Route::controller(App\Http\Controllers\TournamentController::class)->group(function () {
    Route::get('/tournaments', 'index')->name('tournaments.index');
    Route::get('/tournaments/{id}', 'show')->name('tournaments.show');
    Route::get('/tournaments/{id}/standings', 'standings')->name('tournaments.standings');
    Route::get('/tournaments/{id}/matches', 'matches')->name('tournaments.matches');
    Route::get('/tournaments/{id}/motions', 'motions')->name('tournaments.motions');
    Route::get('/tournaments/{id}/results', 'results')->name('tournaments.results');
    Route::get('/tournaments/{id}/speakers', 'speakers')->name('tournaments.speakers');
    Route::get('/tournaments/{id}/participants', 'participants')->name('tournaments.participants');
});

Route::controller(App\Http\Controllers\ArticleController::class)->group(function () {
    Route::get('/articles', 'index')->name('articles.index');
    Route::get('/articles/{slug}', 'show')->name('articles.show');
});

Route::view('/about', 'about')->name('about');

// Auth Routes (Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Tournaments Management
    Route::resource('tournaments', App\Http\Controllers\Admin\TournamentController::class);
    Route::get('/tournaments/{tournament}/import', [App\Http\Controllers\Admin\TournamentController::class, 'import'])->name('tournaments.import');
    Route::post('/tournaments/{tournament}/import', [App\Http\Controllers\Admin\TournamentController::class, 'processImport'])->name('tournaments.processImport');
    Route::get('/tournaments/{tournament}/import-errors', [App\Http\Controllers\Admin\TournamentController::class, 'downloadImportErrors'])->name('tournaments.downloadImportErrors');

    // Teams Management
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);

    // Rounds Management
    Route::post('/rounds/auto-create', [App\Http\Controllers\Admin\RoundController::class, 'autoStore'])->name('rounds.auto-store');
    Route::post('/rounds/{round}/toggle-motion', [App\Http\Controllers\Admin\RoundController::class, 'toggleMotionVisibility'])->name('rounds.toggle-motion');
    Route::post('/rounds/{round}/toggle-draw', [App\Http\Controllers\Admin\RoundController::class, 'toggleDrawVisibility'])->name('rounds.toggle-draw');
    Route::resource('rounds', App\Http\Controllers\Admin\RoundController::class);

    // Matches Management
    Route::resource('matches', App\Http\Controllers\Admin\MatchController::class);
    Route::post('/matches/auto-generate', [App\Http\Controllers\Admin\MatchController::class, 'autoGenerate'])->name('matches.auto-generate');

    // Motions Management
    Route::resource('motions', App\Http\Controllers\Admin\MotionController::class);
    Route::post('/rounds/{round}/publish-motion', [App\Http\Controllers\Admin\MotionController::class, 'publishMotion'])->name('rounds.publishMotion');
    Route::post('/rounds/{round}/unpublish-motion', [App\Http\Controllers\Admin\MotionController::class, 'unpublishMotion'])->name('rounds.unpublishMotion');
    Route::post('/rounds/{round}/publish-draw', [App\Http\Controllers\Admin\MotionController::class, 'publishDraw'])->name('rounds.publishDraw');
    Route::post('/rounds/{round}/unpublish-draw', [App\Http\Controllers\Admin\MotionController::class, 'unpublishDraw'])->name('rounds.unpublishDraw');

    // Adjudicators Management
    Route::resource('adjudicators', App\Http\Controllers\Admin\AdjudicatorController::class);

    // Rooms Management
    Route::resource('rooms', App\Http\Controllers\Admin\RoomController::class);

    // Ballot / Scoring
    Route::get('/ballots', [App\Http\Controllers\Admin\BallotController::class, 'index'])->name('ballots.index');
    Route::get('/ballots/{match}/create', [App\Http\Controllers\Admin\BallotController::class, 'create'])->name('ballots.create');
    Route::post('/ballots/{match}', [App\Http\Controllers\Admin\BallotController::class, 'store'])->name('ballots.store');

    // Adjudicator Reviews
    Route::get('/matches/{match}/reviews', [App\Http\Controllers\Admin\AdjudicatorReviewController::class, 'create'])->name('adjudicator-reviews.create');
    Route::post('/matches/{match}/reviews', [App\Http\Controllers\Admin\AdjudicatorReviewController::class, 'store'])->name('adjudicator-reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\AdjudicatorReviewController::class, 'destroy'])->name('adjudicator-reviews.destroy');

    // Match Management & Scoring
    Route::get('/match-scoring', [App\Http\Controllers\Admin\MatchScoringController::class, 'index'])->name('match-scoring.index');
    Route::get('/match-scoring/{tournament}', [App\Http\Controllers\Admin\MatchScoringController::class, 'show'])->name('match-scoring.show');
    Route::get('/tournament-dashboard/{tournament}', [App\Http\Controllers\Admin\MatchScoringController::class, 'dashboard'])->name('tournament-dashboard');
});

// API Routes for AJAX
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/tournaments/{tournament}/rounds', [App\Http\Controllers\Api\MatchManagementController::class, 'getRounds']);
    Route::get('/rounds/{round}/matches', [App\Http\Controllers\Api\MatchManagementController::class, 'getMatches']);
    Route::get('/rounds/{round}/adjudicators', [App\Http\Controllers\Api\MatchManagementController::class, 'getAdjudicatorsByRound'])->name('api.round.adjudicators');
    Route::get('/matches/{match}/adjudicators', [App\Http\Controllers\Api\MatchManagementController::class, 'getAdjudicatorsByDraw'])->name('api.draw.adjudicators');
    Route::get('/teams/{team}/speakers', [App\Http\Controllers\Api\MatchManagementController::class, 'getSpeakersByTeam'])->name('api.team.speakers');
    Route::post('/matches/{match}/score', [App\Http\Controllers\Api\MatchManagementController::class, 'submitScore'])->name('api.match.score');

    // Draw Management
    Route::post('/rounds/{round}/generate-draw', [App\Http\Controllers\Api\DrawController::class, 'generateDraw'])->name('api.draw.generate');
    Route::post('/rounds/{round}/toggle-lock', [App\Http\Controllers\Api\DrawController::class, 'toggleLock'])->name('api.draw.lock');
    Route::post('/rounds/{round}/publish-draw', [App\Http\Controllers\Api\MatchManagementController::class, 'publishDraw'])->name('api.draw.publish');
    Route::post('/rounds/{round}/publish-motion', [App\Http\Controllers\Api\MatchManagementController::class, 'publishMotion'])->name('api.motion.publish');

    Route::get('/tournaments/{tournament}/ballot-status/{round?}', [App\Http\Controllers\Api\MatchManagementController::class, 'getBallotStatus']);
    Route::post('/verify-ballot-password', [App\Http\Controllers\Api\MatchManagementController::class, 'verifyBallotPassword']);
    Route::get('/matches/{match}/details', [App\Http\Controllers\Admin\MatchScoringController::class, 'getMatchDetails']);
});

require __DIR__ . '/auth.php';
