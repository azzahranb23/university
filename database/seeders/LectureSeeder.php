<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LectureSeeder extends Seeder
{
    public function run()
    {
        // Data from API
        $endpoints = [
            ['id_periode' => 20241, 'id_program_studi' => 3],
            ['id_periode' => 20241, 'id_program_studi' => 4]
        ];

        foreach ($endpoints as $params) {
            try {

                $apiUsername = env('API_USERNAME', 'default_username');
                $apiPassword = env('API_PASSWORD', 'default_password');
                $apiKeyName = env('API_KEY_NAME', 'default_key_name');
                $apiKeySecret = env('API_KEY_SECRET', 'default_key_secret');

                $response = Http::asForm()
                    ->withBasicAuth($apiUsername, $apiPassword)
                    ->withHeaders([
                        'API_KEY_NAME' => $apiKeyName,
                        'API_KEY_SECRET' => $apiKeySecret,
                    ])
                    ->post('https://api.upnvj.ac.id/data/list_dosen_pengajar', $params);

                $data = $response->json()['data'] ?? [];

                foreach ($data as $dosen) {
                    if (empty($dosen['nidn_dosen'])) {
                        continue;
                    }

                    User::updateOrCreate(
                        ['nim_nip' => $dosen['nidn_dosen']],
                        [
                            'name' => $dosen['nama_dosen'] ?? 'Unknown',
                            'email' => $dosen['email'] ?? "dummy-email-{$dosen['nidn_dosen']}@example.com",
                            'phone' => null,
                            'gender' => null,
                            'year' => null,
                            'major_id' => $dosen['id_program_studi'] ?? null,
                            'department_id' => $this->getDepartmentId($dosen['id_program_studi'] ?? null),
                            'role' => 'lecturer',
                            'password' => Hash::make($dosen['nidn_dosen']),
                        ]
                    );
                }
                Log::info('API Response Data:', $response->json());

                Log::info("Seeder sukses untuk id_program_studi: {$params['id_program_studi']}");
            } catch (\Exception $e) {
                Log::error("Error saat seeding data dosen untuk id_program_studi: {$params['id_program_studi']} - {$e->getMessage()}");
            }
        }
    }

    private function getDepartmentId($majorId)
    {
        $major = DB::table('majors')->where('major_id', $majorId)->first();
        return $major ? $major->department_id : null;
    }
}
