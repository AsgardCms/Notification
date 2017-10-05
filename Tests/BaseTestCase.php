<?php

namespace Modules\Notification\Tests;

use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Notification\Providers\NotificationServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Collective\Html\HtmlServiceProvider::class,
            LaravelLocalizationServiceProvider::class,
            LaravelModulesServiceProvider::class,
            CoreServiceProvider::class,
            NotificationServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Eloquent' => 'Illuminate\Database\Eloquent\Model',
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
            'Form' => \Collective\Html\FormFacade::class,
            'Html' => \Collective\Html\HtmlFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
        $app['config']->set('modules.paths.modules', __DIR__ . '/../Modules');
    }

    private function resetDatabase()
    {
        // Makes sure the migrations table is created
        $this->artisan('migrate', [
            '--database' => 'sqlite',
        ]);
        // We empty all tables
        $this->artisan('migrate:reset', [
            '--database' => 'sqlite',
        ]);
        // Migrate
        $this->artisan('migrate', [
            '--database' => 'sqlite',
        ]);
    }
}
