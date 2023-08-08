<?php

namespace App\Http\View\Composers;


use App\Models\Reviewer\Reviewer;
use Illuminate\View\View;

class  ReviewerComposer
{
    public function compose(View $view)
    {
        $view->with('reviewers',
            Reviewer::where('district', session('district'))->where('is_active', 1)->get());
    }
}
