<?php

namespace Clevyr\LaravelTwilioChannel\Channels;

use Clevyr\LaravelTwilioChannel\Contracts\TwilioNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\App;
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
        if (App::environment() == 'testing') {
            // If we're in test mode, don't create a twilio client so that we
            // don't actually send texts.
            return;
        }

        $this->from_phone_number = config('twilio-channel.phone_number');

        $account_sid = config('twilio-channel.sid');
        $auth_token = config('twilio-channel.auth_token');

        $this->client = new Client($account_sid, $auth_token);
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
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

        // Get the phone number from the notification. Supports on-demand
        // notifications, as well as normal notifiable notifications.
        $phoneNumber = $this->getRecipientPhoneNumber($notifiable);

        // Send the SMS message
        $this->client->messages->create($phoneNumber, [
            'from' => $this->from_phone_number,
            'body' => $twilioMessage->fullMessage(),
        ]);
    }

    private function getRecipientPhoneNumber(mixed $notifiable): string
    {
        if ($notifiable instanceof AnonymousNotifiable && array_key_exists('twilio', $notifiable->routes)) {
            return strval($notifiable->routes['twilio']);
        }

        if ($notifiable->twilioPhoneNumberField !== null) {
            return $notifiable->twilioPhoneNumberField;
        }

        return $notifiable->phone_number;
    }
}
