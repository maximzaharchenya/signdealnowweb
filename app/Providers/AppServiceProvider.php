<?php

namespace App\Providers;

use App\Models\Document;
use App\Observers\DocumentObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Passport;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        JsonResource::withoutWrapping();
        Document::observe(DocumentObserver::class);
        Passport::routes();
    }
}
