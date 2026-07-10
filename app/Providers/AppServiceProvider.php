<?php

namespace App\Providers;

use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionRecipe;
use App\Observers\Promotion\PromotionObserver;
use App\Observers\Transaction\TransactionDetailObserver;
use App\Observers\Transaction\TransactionRecipeObserver;
use App\Observers\TransactionObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        Http::globalOptions([
            'timeout' => 10,
            'connect_timeout' => 5,
        ]);

        // Model::preventLazyLoading(! $this->app->isProduction());

        // Force all generated URLs to use the exact APP_URL (including port).
        // This prevents Livewire redirect responses from stripping the port number,
        // which causes CORS errors when the PHP built-in server rewrites the Host header.
        URL::forceRootUrl(config('app.url'));

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
