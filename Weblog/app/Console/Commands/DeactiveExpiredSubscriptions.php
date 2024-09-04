<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class DeactivateExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:deactivate-expired';
    protected $description = 'Deactivate expired subscriptions based on the end date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        // Find all active subscriptions where the end date is past today
        $expiredSubscriptions = Subscription::where('active', true)
            ->where('end_date', '<', $today)
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['active' => false]);
            $this->info("Deactivated subscription ID: {$subscription->id}");
        }

        return 0;
    }
}
