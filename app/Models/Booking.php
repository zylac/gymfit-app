<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'member_id',
        'pt_id',
        'membership_plan_id',
        'schedule_time',
        'status',
        'member_notes',
        'pt_notes',
        'amount',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function pt()
    {
        return $this->belongsTo(User::class, 'pt_id');
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
