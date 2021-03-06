<?php

namespace Wiki\Units\Customer\Providers;

use Wiki\Support\Units\ServiceProvider;
use Wiki\Domains\Customer\Models\Customer;

class UnitServiceProvider extends ServiceProvider
{
    
    /**
     * @var array List of Unit Service Providers to Register
     */
    protected $providers = [
        RouteServiceProvider::class,
    ];

    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [];

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

}