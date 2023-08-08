<?php

namespace App\Http\View\Composers;


use App\Models\County\County;
use Illuminate\View\View;

class  CountyComposer
{
    public function compose(View $view)
    {
        $view->with('counties', County::all());
    }
}
