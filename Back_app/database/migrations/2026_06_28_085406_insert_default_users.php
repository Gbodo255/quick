<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@crediteco.app'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'account@crediteco.app'],
            [
                'name' => 'Employé',
                'password' => Hash::make('Account123'),
                'role' => 'employee',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::whereIn('email', ['admin@crediteco.app', 'account@crediteco.app'])->delete();
    }
};
