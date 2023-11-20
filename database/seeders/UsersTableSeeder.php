<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Lê Anh Huy',
            'email' => 'huyanhit@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('761148'),
            'remember_token' => Str::random(10),
        ]);
    }
}
