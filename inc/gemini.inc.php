<?php
function plugin_aiticketrouter_gemini_analyze($title, $content) {
    $api_key = 'AIzaSyBU54U0vFlLnE-g3TxR-LSeSEw6CfToask'; // Get from https://aistudio.google.com/app/apikey
    
    $prompt = "Analyze this IT ticket. Return ONLY valid JSON:
    {
        \"category\": \"Hardware|Network|Software|Security|General\",
        \"urgency\": 1-5,
        \"impact\": 1-5,
        \"solutions\": [\"solution1\", \"solution2\", \"solution3\"],
        \"keywords\": [\"kw1\", \"kw2\"]
    }
    
    Title: $title
    Description: $content";
    
    $data = [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ],
        'generationConfig' => [
            'temperature' => 0.2,
            'responseMimeType' => 'application/json'
        ]
    ];
    
    $ch = curl_init("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $api_key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for local dev
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return ['error' => "cURL: $error"];
    }
    
    $result = json_decode($response, true);
    $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
    
    // Clean and parse JSON
    $text = preg_replace('/```json\s*|\s*```/', '', $text);
    return json_decode($text, true) ?: ['error' => 'Invalid response'];
}