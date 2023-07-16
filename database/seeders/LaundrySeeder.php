<?php

namespace Database\Seeders;

use App\Models\Laundries;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LaundrySeeder extends Seeder
{
    public function run()
    {
        $laundries = [
            [
                'name' => 'Resik Laundry',
                'address' => 'Jalan Jambu Kutorejo, No,40',
                'description' => 'Cuci Cepat Bersih dan Wangi',
                'price_kilo' => '8000',
                'image' => 'https://lh3.googleusercontent.com/p/AF1QipNeiJ1ek-lYE6xcB_AxW8CeCCBSuypn5E350cXS=w1024-k',
                'user_id' => '2'
            ],
        ];

        foreach ($laundries as $userItem) {
            Laundries::create($userItem);
        }
    }
}
