<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Adjudicator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tournaments' => Tournament::count(),
            'total_teams' => Team::count(),
            'total_adjudicators' => Adjudicator::count(),
            'active_tournament' => Tournament::where('status', 'ongoing')->first(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
