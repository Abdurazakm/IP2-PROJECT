<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config/config.php"; // Ensure this path is correct and GEMINI_API_KEY is defined.

function sendMessageToGemini($userInput) {
    // Check if API key is defined
    if (!defined('GEMINI_API_KEY') || empty(GEMINI_API_KEY)) {
        http_response_code(500);
        echo json_encode(["error" => "GEMINI_API_KEY is not defined or empty in config.php."]);
        exit;
    }

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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Consider removing in production if you have proper CA certs
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any

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

    header("Content-Type: application/json");

    if ($httpCode !== 200) {
        // If the HTTP code is not 200, it indicates an API issue or bad request.
        // Try to decode the response even if it's an error, as Gemini often sends error details in JSON.
        $errorData = json_decode($response, true);
        $errorMessage = $errorData['error']['message'] ?? "Unknown API error.";
        http_response_code($httpCode); // Set the correct HTTP status code from the Gemini API
        echo json_encode([
            "error" => "Gemini API error: " . $errorMessage,
            "httpCode" => $httpCode,
            "raw" => $response // Include raw response for debugging
        ]);
        exit;
    }

    $responseData = json_decode($response, true);

    // Check if decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to decode JSON response from Gemini.", "raw" => $response]);
        exit;
    }

    // Safely access the reply
    $botReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "No readable response from Gemini or unexpected format.";
    echo json_encode(["reply" => $botReply]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $message = trim($input['message'] ?? '');

    if (empty($message)) {
        http_response_code(400);
        echo json_encode(["error" => "Message cannot be empty."]);
        exit;
    }

    sendMessageToGemini($message);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only POST requests are allowed."]);
}
?>