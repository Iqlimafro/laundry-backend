<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'Stalin',
                'password' => Hash::make('1234'),
                'address' => 'Jalan Magersari no.7 Belakang Puskesmas',
                'phone' => '0874',
                'role' => 'user',
                'remember_token' => Str::random(40)
            ],
            [
                'username' => 'reykazuko',
                'password' => Hash::make('1234'),
                'address' => 'Pandaan',
                'phone' => '0858',
                'role' => 'mitra',
                'remember_token' => Str::random(40)
            ],
        ];

        foreach ($users as $userItem) {
            User::create($userItem);
        }
    }
}
