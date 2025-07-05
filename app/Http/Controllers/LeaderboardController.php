<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\User; 
class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil 3 teratas untuk podium
        $podium = User::where('role_id', 3)->orderBy('points', 'desc')->take(3)->get();

        // Ambil selain 3 teratas untuk leaderboard (mulai dari urutan ke-4)
        $leaderboard = User::where('role_id', 3)
            ->orderBy('points', 'desc')
            ->skip(3)
            ->paginate(20);
        
        $totalPeserta = User::where('role_id', 3)->count();
        $pointTertinggi = User::where('role_id', 3)->max('points');
        $rataRataPoin = User::where('role_id', 3)->avg('points');

        return view('survey.leaderboard', compact('podium', 'leaderboard', 'totalPeserta', 'pointTertinggi', 'rataRataPoin'));
    }

    // Method untuk implementasi dengan database
    public function indexFromDatabase()
    {
        // Contoh query jika menggunakan model User dengan kolom points
        // $leaderboard = User::orderBy('points', 'desc')->get();
        
        // Atau jika menggunakan model terpisah untuk leaderboard
        // $leaderboard = Participant::with('user')
        //     ->orderBy('points', 'desc')
        //     ->get();

        return view('survey.leaderboard', compact('leaderboard'));
    }
}