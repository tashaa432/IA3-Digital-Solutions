<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
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
                echo "<br>";
            }
        } else {
            // Display the correct error message based on the error code
            $error_messages = [
                1 => "No Results: The API doesn't have enough questions for your query.",
                2 => "Invalid Parameter: Contains an invalid parameter. Arguments passed in aren't valid.",
                3 => "Token Not Found: Session Token does not exist.",
                4 => "Token Empty: Session Token has returned all possible questions for the specified query. Resetting the Token is necessary.",
                5 => "Rate Limit: Too many requests have occurred."
            ];
    
            $error_code = $data['response_code'];
            if (isset($error_messages[$error_code])) {
                echo "An error occurred: " . $error_messages[$error_code] . " (Error Code: $error_code)";
            } else {
                echo "An unknown error occurred. (Error Code: $error_code)";
            }
        }
    
    }
    ?>

</body>
</html>
