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

    // Teams Management
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);

    // Rounds Management
    Route::resource('rounds', App\Http\Controllers\Admin\RoundController::class);

    // Matches Management
    Route::resource('matches', App\Http\Controllers\Admin\MatchController::class);

    // Motions Management
    Route::resource('motions', App\Http\Controllers\Admin\MotionController::class);

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
    Route::get('/matches/{match}/adjudicators', [App\Http\Controllers\Api\MatchManagementController::class, 'getAdjudicatorsByDraw'])->name('api.draw.adjudicators');
    Route::get('/teams/{team}/speakers', [App\Http\Controllers\Api\MatchManagementController::class, 'getSpeakersByTeam'])->name('api.team.speakers');
    Route::post('/matches/{match}/score', [App\Http\Controllers\Api\MatchManagementController::class, 'submitScore'])->name('api.match.score');
    Route::post('/rounds/{round}/publish-draw', [App\Http\Controllers\Api\MatchManagementController::class, 'publishDraw'])->name('api.draw.publish');
    Route::post('/rounds/{round}/publish-motion', [App\Http\Controllers\Api\MatchManagementController::class, 'publishMotion'])->name('api.motion.publish');
    Route::get('/tournaments/{tournament}/ballot-status/{round?}', [App\Http\Controllers\Api\MatchManagementController::class, 'getBallotStatus']);
    Route::post('/verify-ballot-password', [App\Http\Controllers\Api\MatchManagementController::class, 'verifyBallotPassword']);
    Route::get('/matches/{match}/details', [App\Http\Controllers\Admin\MatchScoringController::class, 'getMatchDetails']);
});

require __DIR__ . '/auth.php';
