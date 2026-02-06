<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\GovernancePolicy;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResponsibleAiService
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function generateResponse(string $prompt, ?int $userId = null, array $history = []): array
    {
        // 1. Policy Check (Pre-Generation)
        // Check if prompt triggers any high-severity blocking policies immediately
        $blockingPolicies = GovernancePolicy::where('is_active', true)
            ->where('severity', 'critical')
            ->get();
            
        // (Simplified: In real app, we might use a small local model to check intent vs policies here)

        // 2. Retrieval (RAG)
        $contextDocs = $this->documentService->findRelevantContext($prompt);
        $contextText = "";
        $sourceIds = [];
        
        if (!empty($contextDocs)) {
            $contextText .= "REFERENSI TERPERCAYA (Gunakan ini sebagai sumber utama):\n";
            foreach ($contextDocs as $doc) {
                $contextText .= "[ID:{$doc['id']}] Judul: {$doc['title']}\nIsi: {$doc['content']}\n\n";
                $sourceIds[] = ['id' => $doc['id'], 'title' => $doc['title']];
            }
        }

        // 2b. Add Active Governance Policies to Prompt
        $activePolicies = GovernancePolicy::where('is_active', true)->get();
        $policyInstructions = "KEBIJAKAN TATA KELOLA (WAJIB DIPATUHI):\n";
        foreach ($activePolicies as $policy) {
            $policyInstructions .= "- [{$policy->category}] {$policy->description}\n";
        }

        // 3. Construct "Responsible" System Prompt
        $systemInstruction = "Kamu adalah 'Earth AI', asisten Enterprise yang bertanggung jawab.\n" .
            "TUGAS: Jawab pertanyaan pengguna dengan akurat, objektif, dan HANYA berdasarkan fakta.\n\n" .
            $contextText . "\n" .
            $policyInstructions . "\n" .
            "ATURAN TAMBAHAN:\n" .
            "1. Jika jawaban ada di 'REFERENSI TERPERCAYA', kutip sumbernya.\n" .
            "2. Jika tidak ada di referensi, gunakan pengetahuan umum tapi tandai sebagai 'Pengetahuan Umum' (Risk Score lebih tinggi).\n" .
            "3. JANGAN mengarang (Halusinasi). Jika tidak tahu, katakan tidak tahu.\n" .
            "4. Berikan output dalam format JSON strict seperti ini:\n" .
            "{\n" .
            "  'text': 'Jawaban kamu di sini...',\n" .
            "  'risk_score': 0-100 (100 = sangat berbahaya/tidak yakin),\n" .
            "  'safety_reasoning': 'Penjelasan teknis singkat mengapa skor risiko ini diberikan (Transparansi)',\n" .
            "  'confidence_score': 0-100,\n" .
            "  'sources': ['List ID referensi yang dipakai']\n" .
            "}\n";

        // 4. Construct "Responsible" Contents with History
        $contents = [];
        foreach ($history as $msg) {
            $role = ($msg['role'] === 'user') ? 'user' : 'model';
            $text = $msg['parts'][0]['text'] ?? '';
            $contents[] = ['role' => $role, 'parts' => [['text' => $text]]];
        }
        // Add current prompt
        $contents[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];

        $payload = [
            'system_instruction' => ['parts' => [['text' => $systemInstruction]]],
            'contents' => $contents,
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature' => 0.7,
                'topP' => 0.95,
                'maxOutputTokens' => 2048,
            ]
        ];

        // 5. Call Gemini v1beta (Best for features)
        $apiKey = env('GEMINI_API_KEY');
        
        try {
            $response = Http::withoutVerifying()->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}",
                $payload
            );

            if ($response->successful()) {
                $rawText = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                $aiData = json_decode($rawText, true);

                // Fallback if JSON parsing fails
                if (!$aiData || !isset($aiData['text'])) {
                    $aiData = [
                        'text' => $rawText,
                        'risk_score' => 20, 
                        'safety_reasoning' => 'Ekstraksi data dari output AI.',
                        'confidence_score' => 80,
                        'sources' => []
                    ];
                }

                // 6. Audit Logging
                AuditLog::create([
                    'user_id' => $userId,
                    'input_prompt' => $prompt,
                    'ai_response' => $aiData['text'] ?? ($rawText ?? 'No text'),
                    'risk_score' => $aiData['risk_score'] ?? 0,
                    'safety_reasoning' => $aiData['safety_reasoning'] ?? 'Tidak ada penjelasan khusus.',
                    'confidence_score' => $aiData['confidence_score'] ?? 0,
                    'sources_used' => $sourceIds,
                    'model_version' => 'Gemini 1.5 Flash (Latest)',
                    'status' => ($aiData['risk_score'] ?? 0) > 70 ? 'flagged' : 'approved'
                ]);

                return $aiData;
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return [
                    'text' => "Maaf, sistem AI sedang mengalami gangguan koneksi. (Kode: {$response->status()})",
                    'risk_score' => 0, 
                    'confidence_score' => 0
                ];
            }
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return [
                'text' => "Terjadi kesalahan internal pada sistem Responsible AI.",
                'risk_score' => 0,
                'confidence_score' => 0
            ];
        }
    }
}
