# Laravel Twilio Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/clevyr/laravel-twilio-channel.svg?style=flat-square)](https://packagist.org/packages/clevyr/laravel-twilio-channel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/clevyr/laravel-twilio-channel/run-tests?label=tests)](https://github.com/clevyr/laravel-twilio-channel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/clevyr/laravel-twilio-channel/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/clevyr/laravel-twilio-channel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/clevyr/laravel-twilio-channel.svg?style=flat-square)](https://packagist.org/packages/clevyr/laravel-twilio-channel)

A Laravel Notification channel for sending SMS messages with [Twilio](https://www.twilio.com/).

## Installation

You can install the package via composer:

```bash
composer require clevyr/laravel-twilio-channel
```

Configure an account on [Twilio](https://www.twilio.com/), and then add the
following env vars:

```
TWILIO_SID=
TWILIO_AUTH_TOKEN=
TWILIO_PHONE_NUMBER=
```

Next, publish the config file with:

```bash
php artisan vendor:publish --provider="Clevyr\LaravelTwilioChannel\LaravelTwilioChannelServiceProvider"
```

This is the contents of the published config file (without descriptive comments):

```php
return [
    'sid' => env('TWILIO_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'phone_number' => env('TWILIO_PHONE_NUMBER'),
];
```

## Usage

In your Laravel notifications:
* Implement the `TwilioNotification` interface
* Add the `TwilioChannel` to your `via` return array value
* Build a `toTwilio` function that returns a `TwilioMessage` object

```php
<?php

namespace App\Notifications;

use Clevyr\LaravelTwilioChannel\Channels\TwilioChannel;
use Clevyr\LaravelTwilioChannel\Contracts\TwilioNotification;
use Clevyr\LaravelTwilioChannel\Messages\TwilioMessage;
use Illuminate\Notifications\Notification;

class MyNotification extends Notification implements TwilioNotification {

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    /**
     * Get the twilio representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Clevyr\LaravelTwilioChannel\Messages\TwilioMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioMessage)
            ->line('Your first line.')
            ->line('A second line, with a break between the last line.');
    }
```

By default, `TwilioChannel` will use your notifiable's `phone_number` field
to send an SMS message, which must be in a format such as `8884445555`.

### Overriding the Notifiable Phone Number Field

To override the `phone_number` and use a different field, set the
`twilioPhoneNumberField` instance variable in your notifiable class:

```php
class User extends Authenticatable
{
    public $twilioPhoneNumberField = 'primary_phone_number';

    //
}
```

### On-Demand Notifications

If you wish to send an on-demand notification, and not use a `notifiable` object
at all, you can do that:

```
use Illuminate\Support\Facades\Notification;

Notification::route('twilio', '5555555555')
    ->notify(new InvoicePaid($invoice));
```

## Testing

```bash
composer test
```

## Linting

```bash
composer analyse
```

## Formatting w/ [Laravel Pint](https://laravel.com/docs/9.x/pint)

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Aaron Krauss](https://github.com/alkrauss48)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
