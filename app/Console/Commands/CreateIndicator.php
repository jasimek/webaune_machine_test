<?php

namespace App\Console\Commands;

use App\Jobs\CreateIndicatorJob;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CreateIndicator extends Command
{
    use DispatchesJobs;

    protected $signature = 'create:create-indicator';

    protected $description = 'Create indicator';

    public function handle()
    {
        $date = Carbon::now()->format('Y-m-d');
        $job = new CreateIndicatorJob($date);
        $this->dispatch($job);
    }
}
