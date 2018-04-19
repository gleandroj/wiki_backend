<?php

namespace Wiki\Units\Core\Providers;

use Wiki\Units\Core\Routes\Api;
use Wiki\Units\Core\Routes\Testing;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Wiki\Units\Core\Routes\Web;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Wiki\Units\Core';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        (new Web([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ]))->register();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        (new Testing([
            'namespace'  => $this->namespace,
        ]))->register();

        (new Api([
            'middleware' => 'api',
            'namespace'  => $this->namespace,
            'prefix' => env('API_PREFIX', 'api')
        ]))->register();
    }
}