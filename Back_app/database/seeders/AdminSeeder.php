<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', env('ADMIN_USERNAME'));
        $password = env('ADMIN_PASSWORD');

        if (empty($email) || empty($password)) {
            $this->command->info('ADMIN_EMAIL or ADMIN_PASSWORD not set; skipping AdminSeeder.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
            ]
        );
    }
}
