<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = 'AIzaSyCq-TrjRvWcAtTEwCRieqqhiSLA9oJ5Mds';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=$apiKey";

$response = Http::get($url);
if ($response->successful()) {
    $models = $response->json()['models'];
    foreach ($models as $m) {
        if (in_array('generateContent', $m['supportedGenerationMethods'])) {
            echo $m['name'] . "\n";
        }
    }
}
