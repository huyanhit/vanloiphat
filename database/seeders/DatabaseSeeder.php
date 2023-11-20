<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        for($i = 1; $i < 10; $i++){
            $this->call(ImagesTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(PostsTableSeeder::class, false, ['image_id' => $i, 'category_id' => $i]);
        }
    }
}
