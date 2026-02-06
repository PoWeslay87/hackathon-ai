<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KnowledgeDocument;

class KnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            [
                'title' => 'Kebijakan Penggunaan AI Generatif',
                'content' => 'Karyawan dilarang memasukkan data rahasia perusahaan (PII, Laporan Keuangan non-publik) ke dalam tool AI publik seperti ChatGPT. Gunakan hanya "Earth AI" internal untuk data sensitif. Segala output AI harus diverifikasi manusia sebelum digunakan.',
                'is_active' => true,
            ],
            [
                'title' => 'Prosedur Cuti Tahunan',
                'content' => 'Setiap karyawan berhak atas 12 hari cuti tahunan setelah masa percobaan 3 bulan. Pengajuan cuti harus dilakukan minimal 3 hari sebelum tanggal cuti melalui portal HRIS. Cuti sakit memerlukan surat dokter jika lebih dari 2 hari.',
                'is_active' => true,
            ],
            [
                'title' => 'Standar Keamanan Data Pribadi (PDP)',
                'content' => 'Data pribadi pelanggan harus dienkripsi saat disimpan (at rest) dan saat dikirim (in transit). Akses ke data pribadi dibatasi hanya untuk personel yang membutuhkan (need-to-know basis). Pelanggaran data harus dilaporkan ke DPO dalam 24 jam.',
                'is_active' => true,
            ],
            [
                'title' => 'Kebijakan Work From Home (WFH)',
                'content' => 'Karyawan diperbolehkan WFH maksimal 2 hari dalam seminggu dengan persetujuan manajer. Saat WFH, karyawan wajib dapat dihubungi selama jam kerja (09:00 - 17:00).',
                'is_active' => true,
            ],
        ];

        foreach ($documents as $doc) {
            KnowledgeDocument::create($doc);
        }
    }
}
