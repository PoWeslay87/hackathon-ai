<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Setup manual env loading for standalone script
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$apiKey = $_ENV['GEMINI_API_KEY'];

echo "Checking models for API KEY: " . substr($apiKey, 0, 10) . "...\n\n";

// Disable SSL verification for manual curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Disable SSL verify
$output = curl_exec($ch);
curl_close($ch);

$data = json_decode($output, true);

if (isset($data['models'])) {
    echo "AVAILABLE MODELS:\n";
    foreach ($data['models'] as $model) {
        if (strpos($model['name'], 'generateContent') !== false || true) {
            echo "- " . $model['name'] . "\n";
            echo "  Methods: " . json_encode($model['supportedGenerationMethods']) . "\n\n";
        }
    }
} else {
    echo "ERROR:\n";
    print_r($data);
}
