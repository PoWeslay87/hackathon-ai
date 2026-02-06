<?php

namespace App\Services;

use App\Models\KnowledgeDocument;
use Illuminate\Support\Str;

class DocumentService
{
    /**
     * Search for documents relevant to the prompt.
     * simplified keyword matching for Hackathon MVP.
     * In production, this would use Vector Search (e.g., Pgvector/ChromaDB).
     */
    public function findRelevantContext(string $prompt, int $limit = 3): array
    {
        $keywords = $this->extractKeywords($prompt);
        
        // Basic implementation: Find docs containing keywords
        $documents = KnowledgeDocument::where('is_active', true)
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->orWhere('content', 'like', "%{$word}%")
                          ->orWhere('title', 'like', "%{$word}%");
                }
            })
            ->take($limit)
            ->get();

        return $documents->map(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'content' => Str::limit($doc->content, 500), // Limit context window
            ];
        })->toArray();
    }

    private function extractKeywords(string $text): array
    {
        // Simple stop-word removal and tokenization
        $stopWords = ['apa', 'bagaimana', 'kenapa', 'siapa', 'kapan', 'dimana', 'yang', 'dan', 'di', 'ke', 'dari', 'ini', 'itu', 'adalah'];
        $words = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9 ]/', '', $text)));
        
        return array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 3 && !in_array($word, $stopWords);
        });
    }
}
