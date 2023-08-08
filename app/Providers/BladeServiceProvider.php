<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Add @var for Variable Assignment
        // Example: @var('foo', 'bar')
        Blade::directive('options', function ($expression) {

            return "<?php echo $expression; ?>";
        });
    }
}
