<?php

namespace App\Http\View\Composers;


use App\Http\Helper\Helper;
use Illuminate\View\View;

class   StatesComposer
{
    public function compose(View $view)
    {
        $view->with('states', Helper::get_states_options());
    }
}
