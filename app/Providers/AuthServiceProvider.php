<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Quotation;
use App\Policies\ClientPolicy;
use App\Policies\QuotationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\Quotation' => 'App\Policies\QuotationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
