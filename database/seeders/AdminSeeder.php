<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    /**
     * Membuat akun Admin Perpustakaan dan Mahasiswa default.
     */
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Admin Perpustakaan',
                'email' => config('app.seed_accounts.admin_email'),
                'password' => config('app.seed_accounts.admin_password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Rio Mahasiswa',
                'email' => config('app.seed_accounts.student_email'),
                'password' => config('app.seed_accounts.student_password'),
                'role' => 'mahasiswa',
            ],
        ];

        foreach ($accounts as $account) {
            if (empty($account['email']) || empty($account['password'])) {
                throw new RuntimeException(
                    'Set SEED_ADMIN_EMAIL, SEED_ADMIN_PASSWORD, SEED_STUDENT_EMAIL, and SEED_STUDENT_PASSWORD in .env before seeding accounts.'
                );
            }

            User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'email_verified_at' => now(),
                    'role' => $account['role'],
                ]
            );
        }
    }
}
