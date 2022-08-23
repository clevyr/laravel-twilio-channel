<?php

namespace Clevyr\LaravelTwilioChannel\Contracts;

interface TwilioNotification
{
    /**
     * Get the twilio representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Clevyr\LaravelTwilioChannel\Messages\TwilioMessage
     */
    public function toTwilio($notifiable);
}
