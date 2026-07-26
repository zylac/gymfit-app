<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class PaymentVerificationService
{
    /**
     * @throws Exception
     */
    public function verifyPayment(int $paymentId, int $verifierId): Payment
    {
        return DB::transaction(function () use ($paymentId, $verifierId) {
            $payment = Payment::lockForUpdate()->findOrFail($paymentId);

            if ($payment->status !== 'PENDING') {
                throw new Exception("Pembayaran sudah diproses sebelumnya.");
            }

            $payment->update([
                'status' => 'VERIFIED',
                'verified_by' => $verifierId,
                'verified_at' => Carbon::now(),
            ]);

            $booking = $payment->booking;
            $booking->update(['status' => 'APPROVED']); // atau AWAITING_PT_APPROVAL tergantung alur

            // Perpanjang masa aktif membership member
            $member = $booking->member;
            $plan = $booking->membershipPlan;

            if ($plan) {
                $currentExpiry = $member->membership_expires_at;
                if (!$currentExpiry || $currentExpiry->isPast()) {
                    $newExpiry = Carbon::now()->addDays($plan->duration_days);
                } else {
                    $newExpiry = $currentExpiry->addDays($plan->duration_days);
                }

                $member->update([
                    'membership_plan_id' => $plan->id,
                    'membership_expires_at' => $newExpiry,
                ]);
            }

            return $payment;
        });
    }
}
