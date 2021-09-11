<?php

namespace App\Providers;

use App\Models\Loan;
use App\Models\Transaction;
use App\Observers\LoanObserver;
use App\Observers\TransactionObserver;
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
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Loan::observe(LoanObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
