<?php namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\Authentication;
use Modules\Notification\Composers\NotificationViewComposer;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Repositories\Cache\CacheNotificationDecorator;
use Modules\Notification\Repositories\Eloquent\EloquentNotificationRepository;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Services\AsgardNotification;

class NotificationServiceProvider extends ServiceProvider
{
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
        $this->app->bind(NotificationRepository::class, function () {
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
