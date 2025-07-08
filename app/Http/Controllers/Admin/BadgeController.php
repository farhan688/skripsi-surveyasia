<?php

namespace App\Http\Controllers\Admin;

use App\Models\Badge;
use App\Models\Survey;
use App\Models\News;
use App\Models\Chart;
use App\Models\QuestionBankSubTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        $title = "Manajemen Badge";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        return view('admin.badges.index', compact('badges', 'title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Badge Baru";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        return view('admin.badges.create', compact('title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
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
            'min_threshold_points' => 'required|integer|min:0',
            'max_threshold_points' => 'nullable|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('badges', 'public');

        Badge::create([
            'name' => $request->name,
            'min_threshold_points' => $request->min_threshold_points,
            'max_threshold_points' => $request->max_threshold_points,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.badges.index')->with('success', 'Badge created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $badge = Badge::findOrFail($id);
        $title = "Edit Badge";
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        return view('admin.badges.edit', compact('badge', 'title', 'surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
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
        $badge = Badge::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'min_threshold_points' => 'required|integer|min:0',
            'max_threshold_points' => 'nullable|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($badge->image_path) {
                Storage::disk('public')->delete($badge->image_path);
            }
            $imagePath = $request->file('image')->store('badges', 'public');
        } else {
            $imagePath = $badge->image_path;
        }

        $badge->update([
            'name' => $request->name,
            'min_threshold_points' => $request->min_threshold_points,
            'max_threshold_points' => $request->max_threshold_points,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.badges.index')->with('success', 'Badge updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $badge = Badge::findOrFail($id);

        if ($badge->image_path) {
            Storage::disk('public')->delete($badge->image_path);
        }

        $badge->delete();

        return redirect()->route('admin.badges.index')->with('success', 'Badge deleted successfully.');
    }
}
