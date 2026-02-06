<?php

namespace Database\Seeders;

use App\Models\GovernancePolicy;
use Illuminate\Database\Seeder;

class GovernancePolicySeeder extends Seeder
{
    public function run(): void
    {
        $policies = [
            [
                'title' => 'Data Privacy & PII Protection',
                'description' => 'Jangan pernah memberikan informasi pribadi (PII) seperti alamat rumah, nomor telepon, atau data finansial rahasia karyawan.',
                'category' => 'privacy',
                'severity' => 'critical',
                'is_active' => true,
            ],
            [
                'title' => 'Anti-Hate Speech & Ethics',
                'description' => 'Hindari memberikan jawaban yang mengandung unsur kebencian, diskriminasi, atau merendahkan martabat orang lain.',
                'category' => 'ethics',
                'severity' => 'high',
                'is_active' => true,
            ],
            [
                'title' => 'Truthfulness & Hallucination Guard',
                'description' => 'Jika informasi tidak ditemukan dalam Knowledge Base, jujur kepada pengguna dan jangan mengarang informasi palsu.',
                'category' => 'safety',
                'severity' => 'medium',
                'is_active' => true,
            ],
            [
                'title' => 'Corporate Identity Guard',
                'description' => 'Selalu bertindak sebagai perwakilan resmi Earth AI dan jangan memberikan jawaban yang merusak nama baik perusahaan.',
                'category' => 'general',
                'severity' => 'low',
                'is_active' => true,
            ],
        ];

        foreach ($policies as $policy) {
            GovernancePolicy::updateOrCreate(
                ['title' => $policy['title']],
                $policy
            );
        }
    }
}
