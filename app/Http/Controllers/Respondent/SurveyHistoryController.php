<?php

namespace App\Http\Controllers\Respondent;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SurveyHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $user = Auth::user();
       
        // get surveys history with query
        $histories = DB::table('users_surveys')
            ->select(
                'users_surveys.id',
                'users_surveys.created_at as users_surveys_createdAt',
                'users_surveys.updated_at as users_surveys_updatedAt',
                'surveys.reward_point',
                'surveys.title'
            )
            ->join('surveys', 'users_surveys.survey_id', 'surveys.id')
            ->where('users_surveys.user_id', $user->id)
            ->orderBy('users_surveys.created_at', 'desc')
            ->get();

        // Get reward balance from the user model
        $saldoReward = $user->reward_balance;

        return view('survey.history', [
            'histories' => $histories,
            'saldoReward' => $saldoReward
        ]);
    }


    public function exchange(Request $request)
    {
        $user = User::find(auth()->id());
        $jumlahTukar = $request->input('jumlah_tukar'); // jumlah point yang ingin ditukar

        // Validasi cukup point
        if ($user->available_points < $jumlahTukar) {
            return back()->with('error', 'Poin tidak cukup untuk ditukar.');
        }

        // Kurangi available_points
        $user->available_points -= $jumlahTukar;

        // Tambahkan ke saldo reward (misal field reward_balance di tabel users)
        $user->reward_balance += $jumlahTukar; // contoh: 1 point = Rp100
        $user->save();

        // // Simpan riwayat penukaran (opsional)
        // DB::table('point_exchanges')->insert([
        //     'user_id' => $user->id,
        //     'points_exchanged' => $jumlahTukar,
        //     'reward_amount' => $jumlahTukar * 100,
        //     'created_at' => now(),
        // ]);

        return back()->with('success', 'Penukaran berhasil!');
    }
}