<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BonusPointThreshold;
use App\Models\Survey;
use App\Models\News;
use App\Models\Chart;
use App\Models\QuestionBankSubTemplate;
use Carbon\Carbon;

class BonusPointThresholdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bonusPointThresholds = BonusPointThreshold::all();
        $title = "Manajemen Bonus Poin";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();

        // Calculate next bonus distribution time
        $now = Carbon::now();
        $nextDistributionTime = $now->next(Carbon::SUNDAY)->startOfDay();

        return view('admin.bonus-points.index', compact('bonusPointThresholds', 'title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act', 'nextDistributionTime'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Bonus Poin Baru";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        return view('admin.bonus-points.create', compact('title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_points' => 'required|integer|min:0',
            'max_points' => 'nullable|integer|min:0',
            'bonus_amount' => 'required|integer|min:1',
        ]);

        BonusPointThreshold::create([
            'name' => $request->name,
            'min_points' => $request->min_points,
            'max_points' => $request->max_points,
            'bonus_amount' => $request->bonus_amount,
        ]);

        return redirect()->route('admin.bonus-points.index')->with('success', 'Bonus Poin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not needed for this feature
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bonusPointThreshold = BonusPointThreshold::findOrFail($id);
        $title = "Edit Bonus Poin";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        return view('admin.bonus-points.edit', compact('bonusPointThreshold', 'title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bonusPointThreshold = BonusPointThreshold::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'min_points' => 'required|integer|min:0',
            'max_points' => 'nullable|integer|min:0',
            'bonus_amount' => 'required|integer|min:1',
        ]);

        $bonusPointThreshold->update([
            'name' => $request->name,
            'min_points' => $request->min_points,
            'max_points' => $request->max_points,
            'bonus_amount' => $request->bonus_amount,
        ]);

        return redirect()->route('admin.bonus-points.index')->with('success', 'Bonus Poin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bonusPointThreshold = BonusPointThreshold::findOrFail($id);
        $bonusPointThreshold->delete();

        return redirect()->route('admin.bonus-points.index')->with('success', 'Bonus Poin berhasil dihapus.');
    }
}