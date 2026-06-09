<?php

namespace App\Providers;

use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionRecipe;
use App\Models\Promotion\PromotionSimplified;
use App\Observers\Transaction\TransactionDetailObserver;
use App\Observers\Transaction\TransactionRecipeObserver;
use App\Observers\TransactionObserver;
use App\Observers\Promotion\PromotionObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Livewire\Blaze\Blaze;

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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        Blade::directive('number', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });
        Carbon::setLocale('id');

        // Transaction::observe(TransactionObserver::class);
        // TransactionDetail::observe(TransactionDetailObserver::class);
        // TransactionRecipe::observe(TransactionRecipeObserver::class);
        PromotionSimplified::observe(PromotionObserver::class);
    }
}
