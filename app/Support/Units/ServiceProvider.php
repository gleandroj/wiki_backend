<?php

namespace Wiki\Support\Units;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelServiceProvider;

/**
 * Class UnitServiceProvider.
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var array List of Unit Service Providers to Register
     */
    protected $providers = [];

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

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->registerPolicies();
    }

    /**
     * Register unity custom domains.
     */
    public function register()
    {
        $this->registerProviders(collect($this->providers));
    }

    /**
     * Register Unit Custom ServiceProviders.
     *
     * @param Collection $providers
     */
    protected function registerProviders(Collection $providers)
    {
        $providers->each(function ($providerClass) {
            $this->app->register($providerClass);
        });
    }
    
    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}