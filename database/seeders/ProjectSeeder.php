<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title' => 'Hospital Resource Management System',
                'description' => 'Proyek membuat aplikasi untuk membantu profesional kesehatan dan hukum dalam mengelola dan melacak kasus-kasus mediko-legal dengan fitur dokumentasi, penjadwalan, dan komunikasi yang terintegrasi.',
                'photo' => 'images/projects/healthcare.jpg',
                'positions' => json_encode([
                    'UI/UX Design',
                    'Front-end Programmer',
                    'Back-end Programmer',
                    'System Analyst'
                ]),
                'duration' => '5 Bulan',
                'benefits' => "- Sertifikasi\n- Portofolio",
                'category_id' => 1,
                'quota' => 3,
                'user_id' => 1,
            ],
            [
                'title' => 'Smart Manufacturing Management System',
                'description' => 'Sistem manajemen manufaktur pintar yang mengintegrasikan IoT dan AI untuk optimasi proses produksi.',
                'photo' => 'images/projects/manufacturing.jpg',
                'positions' => json_encode([
                    'IoT Developer',
                    'AI Engineer',
                    'Full-stack Developer'
                ]),
                'duration' => '6 Bulan',
                'benefits' => "- Sertifikasi\n- Pengalaman Industri\n- Insentif Bulanan",
                'category_id' => 3,
                'quota' => 2,
                'user_id' => 1,
            ],
            [
                'title' => 'Virtual Health Consultation Platform',
                'description' => 'Platform konsultasi kesehatan virtual yang menghubungkan pasien dengan dokter secara online.',
                'photo' => 'images/projects/telehealth.jpg',
                'positions' => json_encode([
                    'Mobile Developer',
                    'Backend Developer',
                    'UI/UX Designer'
                ]),
                'duration' => '4 Bulan',
                'benefits' => "- Sertifikasi\n- Portfolio\n- Pengalaman Startup",
                'category_id' => 2,
                'quota' => 2,
                'user_id' => 2,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
