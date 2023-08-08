<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production') || $this->app->environment('staging')) {
            \URL::forceScheme('https');
        }

        DB::listen(function ($query) {
//           echo($query->sql);
        });

        Schema::defaultStringLength(191);

        Blade::directive('editMode', function () {

            //Project is in edit note mode
            return "<?php if(request()->routeIs('projects.edit')) : ?>";
        });

        Blade::directive('endEditMode', function () {
            return '<?php endif; ?>';
        });
    }
}
