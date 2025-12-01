<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add nonce directive for CSP
        Blade::directive('nonce', function () {
            return "<?php echo 'nonce=\"' . request()->attributes->get('csp_nonce') . '\"'; ?>";
        });
    }
}
