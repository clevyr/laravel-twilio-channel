<?php

use Clevyr\LaravelTwilioChannel\Messages\TwilioMessage;

beforeEach(function () {
    $this->message = new TwilioMessage;

    $this->message
        ->line('Line 1')
        ->line('Line 2');
});

it('can add lines', function () {
    expect(count($this->message->message))->toBe(2);
    expect($this->message->message[1])->toBe('Line 2');
});

it('prints the full message', function () {
    expect($this->message->fullMessage())->toBe("Line 1\n\nLine 2");
});
