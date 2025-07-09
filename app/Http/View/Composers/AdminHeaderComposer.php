<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Survey;
use App\Models\News;
use App\Models\Chart;
use App\Models\QuestionBankSubTemplate;

class AdminHeaderComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $questionbank_sub_templates_act = QuestionBankSubTemplate::with('template')->get();
        $surveysPending = Survey::where('status', 'pending')->with('user')->orderBy('updated_at', 'asc')->get()->filter(function ($survey) {
            return $survey->user !== null;
        });
        $news = News::latest()->get();
        $charts = Chart::latest()->get();

        $view->with(compact('surveysPending', 'news', 'charts', 'questionbank_sub_templates_act'));
    }
}
