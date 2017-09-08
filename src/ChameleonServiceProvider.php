<?php

namespace Ftiersch\Chameleon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ChameleonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load the package specific routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        
        // The @impersonating directive is basically an if() to check
        // if the user is impersonating someone currently.
        // This can be used to display a "back" button for example.
        Blade::directive('impersonating', function () {
            return "<?php if (session()->has('ftiersch-chameleon-is-impersonating')) { ?>";
        });        
        Blade::directive('endimpersonating', function () {
            return "<?php } ?>";
        });
        
        Blade::directive('canimpersonate', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->canImpersonate($expression) && !session()->has('ftiersch-chameleon-is-impersonating')) { ?>";
        });        
        Blade::directive('endcanimpersonate', function () {
            return "<?php } ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
