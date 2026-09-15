<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::where('email', 'admin@crediteco.app')->update(['email' => 'admin@studcredit.com']);
        User::where('email', 'account@crediteco.app')->update(['email' => 'account@studcredit.com']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::where('email', 'admin@studcredit.com')->update(['email' => 'admin@crediteco.app']);
        User::where('email', 'account@studcredit.com')->update(['email' => 'account@crediteco.app']);
    }
};
