<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    /**
     * @throws Exception
     */
    public function createBooking(int $memberId, int $ptId, int $planId, string $scheduleTime, string $notes = null): Booking
    {
        return DB::transaction(function () use ($memberId, $ptId, $planId, $scheduleTime, $notes) {
            // Cek apakah member punya booking aktif yang belum selesai/expired
            $activeBooking = Booking::where('member_id', $memberId)
                ->whereIn('status', ['PENDING_PAYMENT', 'AWAITING_VERIFICATION'])
                ->first();

            if ($activeBooking) {
                throw new Exception("Anda masih memiliki booking yang belum diselesaikan pembayarannya.");
            }

            // Lock for update untuk mencegah double booking pada PT di jam yang sama
            $existingBooking = Booking::where('pt_id', $ptId)
                ->where('schedule_time', $scheduleTime)
                ->whereNotIn('status', ['REJECTED', 'EXPIRED'])
                ->lockForUpdate()
                ->first();

            if ($existingBooking) {
                throw new Exception("Jadwal PT pada waktu tersebut sudah penuh. Silakan pilih waktu lain.");
            }

            $plan = MembershipPlan::findOrFail($planId);

            $booking = Booking::create([
                'member_id' => $memberId,
                'pt_id' => $ptId,
                'membership_plan_id' => $planId,
                'schedule_time' => $scheduleTime,
                'status' => 'PENDING_PAYMENT',
                'amount' => $plan->price,
                'member_notes' => $notes,
            ]);

            return $booking;
        });
    }
}
