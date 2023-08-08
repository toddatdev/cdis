<?php

namespace App\Http\View\Composers;


use App\Http\Helper\Helper;
use Illuminate\View\View;

class SelectOptionsComposer
{

    public function compose(View $view)
    {
        $plan_types = Helper::get_plan_type_opts();
        $ownerships = Helper::get_ownership_opts();
        $fee_types = Helper::get_fee_type_options();
        $admin_statuses = Helper::get_admin_status_options();
        $tech_statuses = Helper::get_tech_status_options();

        $view->with('options', ['plan_types' => $plan_types,
            'ownerships' => $ownerships,
            'fee_types' => $fee_types,
            'admin_statuses' => $admin_statuses,
            'tech_statuses' => $tech_statuses
        ]);
    }
}
