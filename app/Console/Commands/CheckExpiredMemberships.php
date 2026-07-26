<?php

namespace App\Console\Commands;

use App\Services\CronJobService;
use Illuminate\Console\Command;

class CheckExpiredMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and process expired memberships';

    /**
     * Execute the console command.
     */
    public function handle(CronJobService $cronService)
    {
        $this->info('Starting membership expiry check...');
        $cronService->checkExpiredMemberships();
        $this->info('Membership expiry check completed.');
    }
}
