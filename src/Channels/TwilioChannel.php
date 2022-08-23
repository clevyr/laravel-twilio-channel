<?php

namespace Clevyr\LaravelTwilioChannel\Channels;

use Clevyr\LaravelTwilioChannel\Contracts\TwilioNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioChannel
{
    /**
     * The twilio client
     *
     * @var \Twilio\Rest\Client|null
     */
    private $client;

    /**
     * The twilio sending phone number
     *
     * @var string
     */
    private $from_phone_number;

    /**
     * Create a new TwilioChannel instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (\App::environment() == 'testing') {
            // If we're in test mode, don't create a twilio client so that we
            // don't actually send texts.
            return;
        }

        $this->from_phone_number = config('twilio.phone_number');

        $account_sid = config('twilio.sid');
        $auth_token = config('twilio.auth_token');

        $this->client = new Client($account_sid, $auth_token);
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Clevyr\LaravelTwilioChannel\Contracts\TwilioNotification  $notification
     * @return void
     */
    public function send($notifiable, TwilioNotification $notification)
    {
        if (! $this->client) {
            Log::warning('Twilio client is not defined. Not sending an SMS message');

            return;
        }

        // Get the message object from the notification
        $twilioMessage = $notification->toTwilio($notifiable);

        // Send the SMS message
        $this->client->messages->create($notifiable->phone_number, [
            'from' => $this->from_phone_number,
            'body' => $twilioMessage->fullMessage(),
        ]);
    }
}
