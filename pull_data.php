<?php
// API endpoint
$url = 'https://opentdb.com/api.php?amount=10'; // Replace 'API_ENDPOINT' with the actual API endpoint URL

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Bypass SSL certificate verification (not recommended for production)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Execute cURL request
$response = curl_exec($ch);

// Check if request was successful
if ($response === false) {
    echo "Failed to fetch data from API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Close cURL session
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Check if JSON decoding was successful
if ($data === null) {
    echo "Failed to decode JSON data.";
    exit;
}

// Check response_code and display appropriate message
if ($data['response_code'] === 0) {
    echo "Data loaded correctly.<br><br>";
} else {
    echo "An error occurred.<br><br>";
}

// Display results
foreach ($data['results'] as $result) {
    echo "Type: " . $result['type'] . "<br>";
    echo "Difficulty: " . $result['difficulty'] . "<br>";
    echo "Category: " . $result['category'] . "<br>";
    echo "Question: " . htmlspecialchars_decode($result['question']) . "<br>";
    echo "Correct Answer: " . htmlspecialchars_decode($result['correct_answer']) . "<br>";
    echo "Incorrect Answers: " . implode(", ", array_map('htmlspecialchars_decode', $result['incorrect_answers'])) . "<br><br>";
}
?>
