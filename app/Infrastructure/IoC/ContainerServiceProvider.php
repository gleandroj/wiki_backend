<?php

namespace Wiki\Infrastructure\IoC;

use Illuminate\Support\ServiceProvider;
use Illuminate\Container\Container as Application;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Event;

use Wiki\Domains\Customer\Contracts\CustomerServiceContract;
use Wiki\Domains\Customer\Services\CustomerService;

use Wiki\Infrastructure\Data\Repositories\CustomerRepository;
use Wiki\Domains\Customer\Repositories\CustomerRepository as CustomerRepositoryContract;

use Wiki\Infrastructure\Data\Repositories\UnitOfWork;
use Wiki\Support\Repositories\UnitOfWorkContract;

use Wiki\Infrastructure\Data\Repositories\Repository;
use Wiki\Support\Repositories\RepositoryContract;

class ContainerServiceProvider extends ServiceProvider
{
    /**
     * Event's Listeners
     * @var array
     */
    protected static $listeners = [
    ];

    /**
     * Register Services
     */
    public function Register()
    {
        self::RegisterServices($this->app, $this);
    }

    /**
     * @param Application $application
     * @param ServiceProvider $provider
     */
    public static function RegisterServices(Application $application, ServiceProvider $provider)
    {
        static::registerSupport($application, $provider);
        static::registerCustomerDomain($application, $provider);
        static::registerAgents($application, $provider);
        static::registerHelper($application, $provider);
        static::registerListeners();
    }

    /**
     * @param Application $application
     * @param ServiceProvider $provider
     */
    private static function registerHelper(Application $application, ServiceProvider $provider)
    {
    }


    /**
     * @param Application $application
     * @param ServiceProvider $provider
    */
    private static function registerSupport(Application $application, ServiceProvider $provider)
    {
        $application->bind(UnitOfWorkContract::class, UnitOfWork::class);
        $application->bind(RepositoryContract::class, Repository::class);
    }

    /**
     * @param Application $application
     * @param ServiceProvider $provider
    */
    private static function registerCustomerDomain(Application $application, ServiceProvider $provider)
    {
        $application->bind(CustomerServiceContract::class, CustomerService::class);
        $application->bind(CustomerRepositoryContract::class, CustomerRepository::class);
    }

    /**
     * @param Application $application
     * @param ServiceProvider $provider
     */
    private static function registerAgents(Application $application, ServiceProvider $provider)
    {
    }

    /**
     * Register core event's listeners
     */
    private static function registerListeners()
    {
        foreach (self::$listeners as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

}