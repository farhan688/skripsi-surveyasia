<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Sample data - dalam implementasi nyata, ambil dari database
        $leaderboard = collect([
            (object) ['id' => 1, 'name' => 'Ahmad Rizki Pratama', 'points' => 2850],
            (object) ['id' => 2, 'name' => 'Siti Nurhaliza', 'points' => 2720],
            (object) ['id' => 3, 'name' => 'Budi Santoso', 'points' => 2650],
            (object) ['id' => 4, 'name' => 'Dewi Sartika', 'points' => 2480],
            (object) ['id' => 5, 'name' => 'Eko Prasetyo', 'points' => 2350],
            (object) ['id' => 6, 'name' => 'Fitri Handayani', 'points' => 2280],
            (object) ['id' => 7, 'name' => 'Gunawan Wijaya', 'points' => 2150],
            (object) ['id' => 8, 'name' => 'Hani Kusuma', 'points' => 2050],
            (object) ['id' => 9, 'name' => 'Indra Permana', 'points' => 1980],
            (object) ['id' => 10, 'name' => 'Joko Widodo', 'points' => 1850],
            (object) ['id' => 11, 'name' => 'Kartika Sari', 'points' => 1750],
            (object) ['id' => 12, 'name' => 'Lukman Hakim', 'points' => 1650],
            (object) ['id' => 13, 'name' => 'Maya Sari', 'points' => 1580],
            (object) ['id' => 14, 'name' => 'Nanda Pratama', 'points' => 1450],
            (object) ['id' => 15, 'name' => 'Oki Setiawan', 'points' => 1350],
        ]);

        // Urutkan berdasarkan poin tertinggi
        $leaderboard = $leaderboard->sortByDesc('points')->values();

        return view('survey.leaderboard', compact('leaderboard'));
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

        return view('survey.eaderboard', compact('leaderboard'));
    }
}use App\Models\User;

public function index()
{
    // Ambil user dengan peran respondent (jika pakai role_id)
    $leaderboard = User::where('role_id', \App\Models\Role::IS_RESPONDENT)
                        ->orderByDesc('points')
                        ->get();

    return view('survey.leaderboard', compact('leaderboard'));
}