<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'organization' => 'App\Models\Organization',
            'prescriber' => 'App\Models\Prescriber',
            'prescriber_type' => 'App\Models\PrescriberType',
            'patient' => 'App\Models\Patient',
            'supporter' => 'App\Models\TreatmentSupporter',
            'appointment' => 'App\Models\Appointment',
            'orgSubscription' => 'App\Models\OrganizationSubscription',
            'user' => 'App\Models\User',
        ]);
    }
}
