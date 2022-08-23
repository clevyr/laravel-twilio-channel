<?php

namespace Clevyr\LaravelTwilioChannel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Clevyr\LaravelTwilioChannel\LaravelTwilioChannel
 */
class LaravelTwilioChannel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Clevyr\LaravelTwilioChannel\LaravelTwilioChannel::class;
    }
}
