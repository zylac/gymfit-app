<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function create()
    {
        $plans = MembershipPlan::where('is_active', true)->get();
        $trainers = User::role('PT')->get();

        return view('bookings.create', compact('plans', 'trainers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'pt_id'              => 'required|exists:users,id',
            'schedule_time'      => 'required|date|after:now',
        ]);

        try {
            $booking = $this->bookingService->createBooking(
                memberId: Auth::id(),
                ptId: $request->pt_id,
                planId: $request->membership_plan_id,
                scheduleTime: $request->schedule_time,
                notes: $request->member_notes
            );

            return redirect()->route('bookings.payment', $booking->id)
                ->with('success', 'Booking berhasil dibuat! Silakan upload bukti pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function payment(Booking $booking)
    {
        // Pastikan hanya owner booking yang bisa lihat
        abort_unless($booking->member_id === Auth::id(), 403);

        $booking->load(['pt', 'membershipPlan', 'payment']);

        return view('bookings.payment', compact('booking'));
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        abort_unless($booking->member_id === Auth::id(), 403);
        abort_unless($booking->status === 'PENDING_PAYMENT', 403, 'Booking tidak memerlukan pembayaran.');

        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount'     => $booking->amount,
                'status'     => 'PENDING',
                'proof_path' => $path,
                'paid_at'    => now(),
            ]
        );

        $booking->update(['status' => 'AWAITING_VERIFICATION']);

        return redirect()->route('dashboard')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Admin akan memverifikasi dalam 1x24 jam.');
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->member_id === Auth::id(), 403);

        // Hanya status PENDING_PAYMENT yang bisa dibatalkan
        $cancellableStatuses = ['PENDING_PAYMENT'];
        if (!in_array($booking->status, $cancellableStatuses)) {
            return redirect()->route('dashboard')
                ->with('error', 'Booking tidak dapat dibatalkan karena sudah diproses atau disetujui.');
        }

        $booking->update(['status' => 'REJECTED']);

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
