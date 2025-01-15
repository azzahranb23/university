<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run()
    {
        $siDept = Department::where('department_name', 'Sistem Informasi')->first();
        $tiDept = Department::where('department_name', 'Teknologi Informasi')->first();

        $majors = [
            [
                'major_name' => 'S1 Sistem Informasi',
                'department_id' => $siDept->department_id
            ],
            [
                'major_name' => 'S1 Sains Data',
                'department_id' => $tiDept->department_id
            ],
            [
                'major_name' => 'S1 Informatika',
                'department_id' => $tiDept->department_id
            ],
            [
                'major_name' => 'D3 Sistem Informasi',
                'department_id' => $siDept->department_id
            ],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
