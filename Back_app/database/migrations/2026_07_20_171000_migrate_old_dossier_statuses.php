<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update old statuses to new enum values
        DB::table('credit_applications')
            ->where('status', 'pending_otp')
            ->update(['status' => 'draft']);

        DB::table('credit_applications')
            ->where('status', 'submitted')
            ->update(['status' => 'a_qualifier']);

        DB::table('credit_applications')
            ->where('status', 'processing')
            ->update(['status' => 'dossier_conforme']);

        DB::table('credit_applications')
            ->where('status', 'approved')
            ->update(['status' => 'offre_emise']);

        DB::table('credit_applications')
            ->where('status', 'completed')
            ->update(['status' => 'cloture_succes']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback is not cleanly possible
    }
};
