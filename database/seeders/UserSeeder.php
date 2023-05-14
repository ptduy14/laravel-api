<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => Str::random(5),
            'email' => Str::random(5).'@gmail.com',
            'phone' => rand(10,20),
            'address' => Str::random(10),
            'gender' => rand(0,1),
            'verify' => rand(0,1),
            'password' => bcrypt('password')
        ]);

        // User::create([
        //     'name' => 'tấn duy',
        //     'email' => 'tanduy123@gmail.com',
        //     'phone' => '0886514681',
        //     'address' => 'cantho',
        //     'gender' => 1,
        //     'verify' => 1,
        //     'password' => bcrypt('duy123')
        // ])->assignRole('admin');
    }
}
