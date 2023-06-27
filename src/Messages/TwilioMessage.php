<?php

namespace Clevyr\LaravelTwilioChannel\Messages;

class TwilioMessage
{
    /**
     * The array of messages that will get combined prior to sending.
     *
     * @var string[]
     */
    public $message = [];

    /**
     * Append an entry into the messages array.
     *
     * @return \Clevyr\LaravelTwilioChannel\Messages\TwilioMessage
     */
    public function line(string $text)
    {
        $this->message[] = $text;

        return $this;
    }

    /**
     * Join the messages array on a newline character and return it.
     *
     * @return string
     */
    public function fullMessage()
    {
        return implode("\n\n", $this->message);
    }
}
