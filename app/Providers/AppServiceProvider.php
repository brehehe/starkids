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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
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

        if (str_starts_with(config('app.url'), 'https://') || $this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Blade::directive('number', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });
        Carbon::setLocale('id');

        // Transaction::observe(TransactionObserver::class);
        // TransactionDetail::observe(TransactionDetailObserver::class);
        // TransactionRecipe::observe(TransactionRecipeObserver::class);
        PromotionSimplified::observe(PromotionObserver::class);

        // Register a global booted event listener for all Eloquent models to apply a default ASC ordering
        Event::listen('eloquent.booted: *', function ($eventName, array $data) {
            $model = $data[0];
            $modelClass = get_class($model);

            if (str_starts_with($modelClass, 'App\\')) {
                $modelClass::addGlobalScope('default_order', function (Builder $builder) {
                    $query = $builder->getQuery();
                    if (empty($query->orders) && empty($query->groups) && empty($query->aggregate)) {
                        // Check if any custom selected columns contain aggregate functions
                        $hasAggregate = false;
                        if (! empty($query->columns)) {
                            foreach ($query->columns as $column) {
                                $colStr = $column instanceof Expression
                                    ? $column->getValue(DB::connection()->getQueryGrammar())
                                    : (string) $column;

                                if (preg_match('/\b(count|sum|avg|min|max|stddev|variance|string_agg|array_agg|json_agg|jsonb_agg)\s*\(/i', $colStr)) {
                                    $hasAggregate = true;
                                    break;
                                }
                            }
                        }

                        if (! $hasAggregate) {
                            $model = $builder->getModel();
                            if ($model->getKeyName()) {
                                $builder->orderBy($model->getTable().'.'.$model->getKeyName(), 'asc');
                            }
                        }
                    }
                });
            }
        });
    }
}
