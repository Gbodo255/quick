<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->string('liveness_session_id')->nullable(); // session Didit
            $table->string('liveness_status')->nullable(); // statut Didit : Approved, Declined, In Review…
            $table->timestamp('liveness_checked_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            $table->dropColumn(['liveness_session_id', 'liveness_status', 'liveness_checked_at']);
        });
    }
};
