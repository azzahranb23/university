<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;
use App\Models\Major;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Departments and Majors first
        $this->call([
            DepartmentSeeder::class,
            MajorSeeder::class,
            CategorySeeder::class,
        ]);

        // Get first department and major for demo users
        $department = Department::first();
        $major = Major::first();

        // Create Demo Users
        $this->seedDemoUsers($department, $major);

        $this->call([
            LectureSeeder::class
        ]);

        // Run Project Seeder after users are created
        $this->call([
            ProjectSeeder::class,
        ]);

    }

    private function seedDemoUsers($department, $major): void
    {
        // Demo Student
        User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@mail.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'nim_nip' => '1234567890',
            'major_id' => $major->major_id,
            'department_id' => $department->department_id,
            'gender' => 'male',
            'phone' => '081234567890',
            'year' => '2024'
        ]);

        // Demo Lecturer
        User::create([
            'name' => 'dosen',
            'email' => 'dosen@mail.com',
            'password' => bcrypt('password'),
            'role' => 'lecturer',
            'nim_nip' => '0987654321',
            'department_id' => $department->department_id,
            'gender' => 'male',
            'phone' => '089876543210'
        ]);

        // Admin User
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'nim_nip' => 'admin001',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'gender' => 'male',
            'phone' => '089876543210'
        ]);
    }
}
