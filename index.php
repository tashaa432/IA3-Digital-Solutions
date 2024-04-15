<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Quiz Display</title>
</head>
<body>
    <h1>Quiz Questions</h1>

    <?php
    // Include the PHP file with API fetching code
    require_once 'pull_data.php';

    // Fetch quiz data from API
    $data = fetchQuizData();

    // Check if data was fetched successfully
    if ($data !== null) {
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
                echo "<li class='correct'>" . htmlspecialchars_decode($result['correct_answer']) . " (Correct)</li>";
                foreach ($result['incorrect_answers'] as $incorrect_answer) {
                    echo "<li class='incorrect'>" . htmlspecialchars_decode($incorrect_answer) . "</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "An error occurred:";
        }
    }
    ?>

</body>
</html>
