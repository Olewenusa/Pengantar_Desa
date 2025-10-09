<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengantar;
use App\Models\Resident;
use Carbon\Carbon;

class PengantarSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa residents untuk contoh
        $residents = Resident::take(10)->get();
        
        if ($residents->count() > 0) {
            $purposes = [
                'Pembuatan KTP',
                'Pendaftaran sekolah',
                'Melamar pekerjaan',
                'Pembuatan SIM',
                'Pendaftaran BPJS',
                'Pembuatan akta kelahiran',
                'Pembuatan surat nikah',
                'Pendaftaran kuliah',
                'Pembuatan passport',
                'Klaim asuransi'
            ];

            $statuses = ['pending', 'accepted', 'rejected'];

            foreach ($residents as $index => $resident) {
                // Generate unique NIK for testing
                $baseNik = '3201012345670';
                $uniqueNik = $baseNik . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

                $statusRT = $statuses[array_rand($statuses)];
                $statusRW = 'pending';
                
                // If RT is accepted, randomly set RW status
                if ($statusRT === 'accepted') {
                    $statusRW = $statuses[array_rand($statuses)];
                }

                Pengantar::create([
                    'resident_id' => $resident->id,
                    'name' => $resident->name,
                    'NIK' => $uniqueNik,
                    'purpose' => $purposes[array_rand($purposes)],
                    'date' => Carbon::now()->addDays(rand(1, 30)),
                    'status_rt' => $statusRT,
                    'status_rw' => $statusRW,
                    'notes_rt' => $statusRT !== 'pending' ? 'Catatan dari RT untuk pengajuan ini.' : null,
                    'notes_rw' => $statusRW !== 'pending' ? 'Catatan dari RW untuk pengajuan ini.' : null,
                    'report_date' => Carbon::now()->subDays(rand(0, 7))
                ]);
            }
        }
    }
}