<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call specific seeders
        $this->call([
            UserSeeder::class,
        ]);

        // Categories
        $categories = [
            ['name' => 'Action', 'slug' => 'action'],
            ['name' => 'Horror', 'slug' => 'horror'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Sci-Fi', 'slug' => 'sci-fi'],
            ['name' => 'Thriller', 'slug' => 'thriller'],
            ['name' => 'Fantasy', 'slug' => 'fantasy'],
        ];

        foreach($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Movies Example
        \App\Models\Movie::create([
            'title' => 'Shadow Protocol',
            'slug' => 'shadow-protocol',
            'description' => 'Agen bayangan mengungkap konspirasi global yang mengancam peradaban.',
            'thumbnail' => 'https://images.unsplash.com/photo-1534804960690-4e14a48618f8?w=800&q=80',
            'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'duration' => '2j 28m',
            'category_id' => 1, // Action
            'views' => 1250,
        ]);

        \App\Models\Movie::create([
            'title' => 'Nusantara Rising',
            'slug' => 'nusantara-rising',
            'description' => 'Kisah perjuangan pahlawan muda dari kepulauan Nusantara.',
            'thumbnail' => 'https://images.unsplash.com/photo-1578269174936-2709b6aeb913?w=800&q=80',
            'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'duration' => '2j 10m',
            'category_id' => 3, // Drama
            'views' => 980,
        ]);
    }
}
