<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CronJobService
{
    public function checkExpiredMemberships(): void
    {
        $expiredUsers = User::whereNotNull('membership_expires_at')
            ->where('membership_expires_at', '<', Carbon::now())
            ->get();

        foreach ($expiredUsers as $user) {
            Log::info("Membership expired for user: {$user->email}");
            // Optional: kirim notifikasi/email ke member bahwa membership sudah expired
        }
    }
}
