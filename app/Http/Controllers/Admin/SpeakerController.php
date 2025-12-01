<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use App\Models\Tournament;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $tournamentFilter = $request->get('tournament_id');
        
        $query = Speaker::with(['team.tournament'])->orderBy('created_at', 'desc');
        
        if ($tournamentFilter) {
            $query->whereHas('team', function ($q) use ($tournamentFilter) {
                $q->where('tournament_id', $tournamentFilter);
            });
        }
        
        $speakers = $query->paginate(20);
        $tournaments = Tournament::orderBy('name')->get();
        
        return view('admin.speakers.index', compact('speakers', 'tournaments', 'tournamentFilter'));
    }
}
