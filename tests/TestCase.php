<?php

namespace lamalama\LaravelProductive\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use lamalama\LaravelProductive\LaravelProductiveServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'lamalama\\LaravelProductive\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelProductiveServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-productive_table.php.stub';
        $migration->up();
        */
    }
}
