<?php

namespace Clevyr\LaravelTwilioChannel;

use Clevyr\LaravelTwilioChannel\Commands\LaravelTwilioChannelCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelTwilioChannelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-twilio-channel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-twilio-channel_table')
            ->hasCommand(LaravelTwilioChannelCommand::class);
    }
}
