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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->foreignId('membership_plan_id')->nullable()->constrained('membership_plans')->nullOnDelete();
            $table->dateTime('membership_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_plan_id']);
            $table->dropColumn(['phone', 'membership_plan_id', 'membership_expires_at']);
        });
    }
};
