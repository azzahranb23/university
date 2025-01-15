<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => 'Teknologi', 'image' => 'images/categories/teknologi.jpg'],
            ['category_name' => 'Kesehatan', 'image' => 'images/categories/kesehatan.jpg'],
            ['category_name' => 'Teknik', 'image' => 'images/categories/teknik.jpg'],
            ['category_name' => 'Ekonomi & Bisnis', 'image' => 'images/categories/ekonomi.jpg'],
            ['category_name' => 'Pendidikan', 'image' => 'images/categories/pendidikan.jpg'],
            ['category_name' => 'Lingkungan', 'image' => 'images/categories/lingkungan.jpg'],
            ['category_name' => 'Hukum', 'image' => 'images/categories/hukum.png'],
            ['category_name' => 'Sosial & Politik', 'image' => 'images/categories/sosial.png'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
