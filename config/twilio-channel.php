<?php

use Clevyr\LaravelTwilioChannel\Channels\TwilioChannel;

// config for Clevyr/LaravelTwilioChannel

return [
    /*
    |--------------------------------------------------------------------------
    | Channel
    |--------------------------------------------------------------------------
    |
    | A simple way to access the channel class, so you don't have to
    | type it out everytime
    |
    */
    'channel' => TwilioChannel::class,

    /*
    |--------------------------------------------------------------------------
    | Twilio Configuration
    |--------------------------------------------------------------------------
    |
    | This includes:
    | * Your Twilio SID
    | * Your Twilio Auth Token
    | * Your selected Twilio Phone number (format: 18884445555)
    |
    */
    'sid' => env('TWILIO_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'phone_number' => env('TWILIO_PHONE_NUMBER'),
];
