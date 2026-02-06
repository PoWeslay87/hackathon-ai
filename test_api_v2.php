<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = 'AIzaSyCq-TrjRvWcAtTEwCRieqqhiSLA9oJ5Mds';
$models = ['gemini-2.0-flash', 'gemini-flash-latest', 'gemini-2.0-flash-lite'];
$versions = ['v1beta', 'v1'];

foreach ($versions as $v) {
    foreach ($models as $m) {
        echo "Testing $v with $m...\n";
        $url = "https://generativelanguage.googleapis.com/$v/models/$m:generateContent?key=$apiKey";
        try {
            $response = Http::timeout(5)->post($url, [
                'contents' => [['parts' => [['text' => 'hi']]]],
                'generationConfig' => ['responseMimeType' => 'application/json']
            ]);
            
            if ($response->successful()) {
                echo "SUCCESS: $v/$m works!\n";
                exit(0);
            } else {
                echo "FAILED: $v/$m - Status: " . $response->status() . " - " . $response->body() . "\n";
            }
        } catch (\Exception $e) {
            echo "ERROR: $v/$m - " . $e->getMessage() . "\n";
        }
    }
}
