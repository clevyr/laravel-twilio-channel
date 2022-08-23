<?php

namespace Clevyr\LaravelTwilioChannel\Commands;

use Illuminate\Console\Command;

class LaravelTwilioChannelCommand extends Command
{
    public $signature = 'laravel-twilio-channel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
