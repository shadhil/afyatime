<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PrescriberRegistered;
use App\Events\FirstAppointment;
use App\Events\OrganizationRegistered;
use App\Events\SubscriptionConfirmed;
use App\Events\OrganizationUnsubscribed;
use App\Events\OrganizationBlocked;
use App\Listeners\SendWelcomeEmailToOrganization;
use App\Listeners\SendWelcomeEmailToPrescriber;
use App\Listeners\SendWelcomeTextToPatient;
use App\Listeners\SendWelcomeEmailToPatient;
use App\Events\SubscriptionPaid;
use App\Listeners\SendPaymentEmailToAdmin;
use App\Listeners\SendPaymentTextToAdmin;
use App\Listeners\SendSubscriptionRisitMail;
use App\Listeners\SendOrgUnsubscribedEmail;
use App\Listeners\SendOrgBlockedEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrganizationRegistered::class => [
            SendWelcomeEmailToOrganization::class,
        ],
        PrescriberRegistered::class => [
            SendWelcomeEmailToPrescriber::class,
        ],
        FirstAppointment::class => [
            SendWelcomeTextToPatient::class,
            SendWelcomeEmailToPatient::class
        ],
        SubscriptionPaid::class => [
            SendPaymentEmailToAdmin::class,
            SendPaymentTextToAdmin::class,
        ],
        SubscriptionConfirmed::class => [
            SendSubscriptionRisitMail::class,
        ],
        OrganizationUnsubscribed::class => [
            SendOrgUnsubscribedEmail::class,
        ],
        OrganizationBlocked::class => [
            SendOrgBlockedEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
