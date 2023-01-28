<?php

namespace lamalama\LaravelProductive\Commands;

use Illuminate\Console\Command;

class LaravelProductiveCommand extends Command
{
    public $signature = 'laravel-productive';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
