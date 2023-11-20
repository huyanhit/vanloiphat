<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($image_id, $category_id): void
    {
        DB::table('posts')->insert([
            'title' => fake()->name(),
            'description' => fake()->text(),
            'content' => fake()->text(),
            'image_id' => $image_id,
            'category_id' => $category_id,
            'active' => true,
        ]);
    }
}
