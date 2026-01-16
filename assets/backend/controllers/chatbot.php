<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// require_once "../config/config.php"; // Ensure this path is correct and GEMINI_API_KEY is defined.

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyB_yqEIhQ1Ub7fw0LOqosfFKR0opQKApvk";

    // Example static history (you can make this dynamic by storing in session or DB)
    $history = [
        [
            "role" => "user",
            "parts" => [
                ["text" => "Hello"]
            ]
        ],
        [
            "role" => "model",
            "parts" => [
                ["text" => "Great to meet you. What would you like to know?"]
            ]
        ]
    ];

    if (isset($_GET['query'])) {
        $textMessage = $_GET['query'];

        // Add the latest user message to the history
        $history[] = [
            "role" => "user",
            "parts" => [
                ["text" => $textMessage]
            ]
        ];

        // Gemini expects a "contents" array (the conversation so far)
        $data = [
            "contents" => $history
        ];

        $geminiapi = curl_init($url);
        curl_setopt($geminiapi, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($geminiapi, CURLOPT_POST, true);
        curl_setopt($geminiapi, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($geminiapi, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($geminiapi);

        if (curl_errno($geminiapi)) {
            echo json_encode(["reply" => "cURL error: " . curl_error($geminiapi)]);
            exit;
        }

        curl_close($geminiapi);

        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $chatResponse = $result['candidates'][0]['content']['parts'][0]['text'];
            echo json_encode(['reply' => $chatResponse]);
        } else {
            echo json_encode(['reply' => "Sorry, I couldn't get a clear response."]);
        }
        exit;
    }
}
