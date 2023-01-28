<?php

namespace lamalama\LaravelProductive;

use lamalama\LaravelProductive\Commands\LaravelProductiveCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelProductiveServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-productive')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-productive_table')
            ->hasCommand(LaravelProductiveCommand::class);
    }
}
