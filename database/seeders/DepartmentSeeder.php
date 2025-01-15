<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['department_name' => 'Sistem Informasi'],
            ['department_name' => 'Teknologi Informasi'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
