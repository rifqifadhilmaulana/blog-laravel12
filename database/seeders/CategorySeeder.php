<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'color' => 'bg-blue-500'],
            ['name' => 'Health', 'slug' => 'health', 'color' => 'bg-pink-500'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'color' => 'bg-purple-500'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan-jasmani', 'color' => 'bg-orange-500'], // FIX
            ['name' => 'Psikologi', 'slug' => 'psikologi-mental', 'color' => 'bg-pink-500'],
            ['name' => 'Kehidupan Sehari-hari', 'slug' => 'kehidupan-sehari-hari', 'color' => 'bg-amber-500'],
            ['name' => 'Ilmu Pengetahuan', 'slug' => 'ilmu-pengetahuan', 'color' => 'bg-indigo-500'],
            ['name' => 'Karier', 'slug' => 'karier-pekerjaan', 'color' => 'bg-cyan-500'],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi-bisnis', 'color' => 'bg-gray-500'], // FIX
            ['name' => 'Budaya Seni', 'slug' => 'budaya-seni', 'color' => 'bg-violet-500'], // purple boleh, tapi violet lebih umum
            ['name' => 'Spiritual', 'slug' => 'spiritual-agama', 'color' => 'bg-green-500'],
            ['name' => 'Pengembangan Diri', 'slug' => 'pengembangan-diri', 'color' => 'bg-yellow-500'],
            ['name' => 'hubung Sosial', 'slug' => 'hubungan-sosial', 'color' => 'bg-teal-500'],
            ['name'=> 'Hobi', 'slug' => 'hobi', 'color' => 'bg-red-500'],
        ];

        foreach ($categories as $category) {
          Category::firstOrCreate(
        ['slug' => $category['slug']], // cek slug unik
        $category // kalau belum ada → insert
    );
}

    }
}
