<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config/config.php";

function sendMessageToGemini($userInput) {
    $url = "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro-002:generateContent?key=" . GEMINI_API_KEY;

    $data = [
        "contents" => [
            [
                "role" => "user",
                "parts" => [
                    ["text" => $userInput]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        http_response_code(500);
        echo json_encode(["error" => "cURL error: " . curl_error($ch)]);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // DEBUG: Write response to file for inspection
    file_put_contents("gemini-response.log", $response);

    // Send status and raw data
    header("Content-Type: application/json");

    if ($httpCode !== 200 || empty($response)) {
        echo json_encode([
            "error" => "Gemini API failed or returned empty response.",
            "httpCode" => $httpCode,
            "raw" => $response
        ]);
        exit;
    }

    $responseData = json_decode($response, true);

    $botReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "No response from Gemini.";
    echo json_encode(["reply" => $botReply]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $message = trim($input['message'] ?? '');
    sendMessageToGemini($message);
}
