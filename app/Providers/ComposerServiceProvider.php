<?php

namespace App\Providers;

use App\Http\View\Composers\CountyComposer;
use App\Http\View\Composers\MunicipalityComposer;
use App\Http\View\Composers\ReviewerComposer;
use App\Http\View\Composers\SelectOptionsComposer;
use App\Http\View\Composers\StatesComposer;
use App\Http\View\Composers\UserComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'layouts/partials/sidebar',
            'projects'
        ], UserComposer::class);

        View::composer([
            'projects',
            'search-projects',
            'generate-letters',
            'site-inspection',
            'reports',
            'admin/reviewer-signatures',
            'layouts/partials/reviewers'
        ], ReviewerComposer::class);

        View::composer(['projects', 'search-projects'],
            MunicipalityComposer::class);

        View::composer(['projects'],
            CountyComposer::class);

        View::composer(['projects', 'admin.contacts'],
            StatesComposer::class);


        View::composer(['projects'],
            SelectOptionsComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
