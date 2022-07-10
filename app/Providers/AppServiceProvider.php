<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
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
        // Решение для работы с Mariadb system versioned tables
        // https://stackoverflow.com/questions/66933669/how-to-write-eloquent-query-for-mariadb-system-versioning
        Builder::macro("bySystemTime", function(string $timestamp = null) {
            $timestamp = $timestamp ? "AS OF TIMESTAMP '$timestamp'" : 'ALL';
            $this->from = DB::raw("`$this->from` FOR SYSTEM_TIME $timestamp");
            return $this;
        });
    }
}
