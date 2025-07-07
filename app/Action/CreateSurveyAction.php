<?php

namespace App\Action;

use App\Http\Requests\CreateSurveyRequest;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CreateSurveyAction
{
    public function execute(CreateSurveyRequest $request)
    {
        # code...
        $estimateCompletion = $request->estimate_completion;
        $maxAttempt = $request->max_attempt == null ? 40 : $request->max_attempt;
        $shareable = $request->has('shareable') ? 1 : 0;
        $reward = $request->reward_point == null ? 0 : $request->reward_point;
        $category = $request->category_id;

        $user = Auth::user();

        Log::info('CreateSurveyAction: User ID ' . $user->id . ', Reward Balance: ' . $user->reward_balance);

        // No price deduction at survey creation

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'category_id' => $category,
            'shareable' => $shareable,
            'signature' => Str::random(4).$request->title,
            'slug' => Str::slug($request->title, '-'),
            'max_attempt' => $maxAttempt,
            'reason_deny' => null,
            'estimate_completion' => $estimateCompletion,
            'reward_point' => $reward,
            'status' => 'pending'
        ]);

        if (!$survey) {
            Log::error('CreateSurveyAction: Gagal membuat survei untuk User ID ' . $user->id);
            return redirect()->back()->withErrors('Internal Server Error');
        }

        Log::info('CreateSurveyAction: Survei berhasil dibuat dengan ID ' . $survey->id . ' untuk User ID ' . $user->id);
        return redirect()->back()->with(['surveys.success', 'Survey Created!']);
    }
}