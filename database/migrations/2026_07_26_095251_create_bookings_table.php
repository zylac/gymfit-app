<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pt_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('membership_plan_id')->nullable()->constrained('membership_plans')->nullOnDelete();
            $table->dateTime('schedule_time');
            $table->string('status')->default('PENDING_PAYMENT');
            $table->text('member_notes')->nullable();
            $table->text('pt_notes')->nullable();
            $table->decimal('amount', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
