<?php

namespace App\Http\View\Composers;


use App\Models\Municipality\Municipality;
use Illuminate\View\View;

class  MunicipalityComposer
{
    public function compose(View $view)
    {
        $view->with('municipalities', Municipality::where('county_id', session('county_id'))->get(['id', 'name']));
    }
}
