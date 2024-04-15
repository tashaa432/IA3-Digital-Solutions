<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Display</title>
</head>
<body>
    <h1>Quiz Questions</h1>

    <?php
    // API endpoint
    $url = 'https://opentdb.com/api.php?amount=10'; // Replace 'API_ENDPOINT' with the actual API endpoint URL

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass SSL certificate verification (not recommended for production)

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
        echo "<p>Data loaded correctly.</p>";
        echo "<br>";

        // Display questions and answers
        foreach ($data['results'] as $result) {
            echo "<h2>Question:</h2>";
            echo "<p>" . htmlspecialchars_decode($result['question']) . "</p>";
            echo "<h3>Answers:</h3>";
            echo "<ul>";
            echo "<li>" . htmlspecialchars_decode($result['correct_answer']) . " (Correct)</li>";
            foreach ($result['incorrect_answers'] as $incorrect_answer) {
                echo "<li>" . htmlspecialchars_decode($incorrect_answer) . "</li>";
            }
            echo "</ul>";
            echo "<hr>";
        }
    } else {
        echo "An error occurred.";
    }
    ?>

</body>
</html>
