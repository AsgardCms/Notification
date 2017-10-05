<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Notification\Composers\NotificationViewComposer;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Events\Handlers\RegisterNotificationSidebar;
use Modules\Notification\Repositories\Cache\CacheNotificationDecorator;
use Modules\Notification\Repositories\Eloquent\EloquentNotificationRepository;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Services\AsgardNotification;
use Modules\User\Contracts\Authentication;

class NotificationServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerViewComposers();

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('blog', RegisterNotificationSidebar::class)
        );
    }

    public function boot()
    {
        $this->publishConfig('notification', 'config');
        $this->publishConfig('notification', 'permissions');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            NotificationRepository::class,
            function () {
                $repository = new EloquentNotificationRepository(new Notification());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new CacheNotificationDecorator($repository);
            }
        );

        $this->app->bind(\Modules\Notification\Services\Notification::class, function ($app) {
            return new AsgardNotification($app[NotificationRepository::class], $app[Authentication::class]);
        });
    }

    private function registerViewComposers()
    {
        view()->composer('partials.top-nav', NotificationViewComposer::class);
    }
}
