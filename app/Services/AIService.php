<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai.url', 'http://127.0.0.1:8001');
    }

    public function generateEmbedding(string $text, string $productId): array
    {
        $response = Http::post("{$this->baseUrl}/generate-embedding", [
            'text'       => $text,
            'product_id' => $productId,
        ]);

        return $response->json();
    }

    public function search(string $query, array $candidates): array
    {
        $response = Http::post("{$this->baseUrl}/search", [
            'query'      => $query,
            'candidates' => $candidates,
        ]);

        return $response->json();
    }
    
    public function chat(string $prompt, string $context): string
{
    $response = Http::post("{$this->baseUrl}/chat", [
        'prompt'  => $prompt,
        'context' => $context,
    ]);

    return $response->json('response', 'No pude generar una respuesta.');
}
}