<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'category_name' => 'Internet of Things (IoT)',
                'image' => 'images/categories/iot.jpg'
            ],
            [
                'category_name' => 'Artificial Intelligence (AI)',
                'image' => 'images/categories/ai.jpeg'
            ],
            [
                'category_name' => 'Machine Learning (ML)',
                'image' => 'images/categories/ml.jpeg'
            ],
            [
                'category_name' => 'Augmented & Virtual Reality (AR/VR)',
                'image' => 'images/categories/ar-vr.jpg'
            ],
            [
                'category_name' => 'Robotics',
                'image' => 'images/categories/robotics.png'
            ],
            [
                'category_name' => 'Data Science & Big Data',
                'image' => 'images/categories/data-science.jpg'
            ],
            [
                'category_name' => 'Cybersecurity',
                'image' => 'images/categories/cybersecurity.jpg'
            ],
            [
                'category_name' => 'Human-Computer Interaction (HCI)',
                'image' => 'images/categories/hci.jpeg'
            ],
            [
                'category_name' => 'Sistem Informasi',
                'image' => 'images/categories/sistem-informasi.jpg'
            ],
            [
                'category_name' => 'Web Development',
                'image' => 'images/categories/web-dev.png'
            ],
            [
                'category_name' => 'Mobile Development',
                'image' => 'images/categories/mobile-dev.png'
            ],
            [
                'category_name' => 'Jaringan Komputer',
                'image' => 'images/categories/jaringan.jpeg'
            ],
            [
                'category_name' => 'Database & Backend System',
                'image' => 'images/categories/database.png'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
