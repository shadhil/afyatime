<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::morphMap([
            'organization' => 'App\Models\Organization',
            'prescriber' => 'App\Models\Prescriber',
            'patient' => 'App\Models\Patient',
            'supporter' => 'App\Models\TreatmentSupporter',
        ]);
    }
}
