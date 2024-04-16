<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
    <title>Trivia</title>
</head>
<body>
    <h1>Question</h1>
    <?php
    // Add in PHP File
    require_once 'pull_data.php';
    // Fetch quiz data from API
    $data = fetchQuizData();
    // Check if data was fetched successfully
    if ($data !== null) {
        // Check response_code then proceeed
        if ($data['response_code'] === 0) {
            // Display questions and answers
            foreach ($data['results'] as $result) {
                echo "<h2>Question:</h2>";
                echo "<p>" . htmlspecialchars_decode($result['question']) . "</p>";
                echo "<h3>Answers:</h3>";
                echo "<table class='answer-table'>";
                
                // Extracting correct and incorrect answers
                $correctAnswer = htmlspecialchars_decode($result['correct_answer']);
                $incorrectAnswers = array_map('htmlspecialchars_decode', $result['incorrect_answers']);
                
                // Combining correct and incorrect answers
                $allAnswers = array_merge([$correctAnswer], $incorrectAnswers);
                
                // Shuffle the combined answers
                shuffle($allAnswers);
                
                // Loop through the answers to create table cells
                foreach ($allAnswers as $answer) {
                    echo "<tr>";
                    echo "<td class='answer-cell' onclick='revealAnswer(this)'>$answer</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "<br>";
            }
        }
    } else {
        // Set error message if required
        $error_messages = [
            1 => "No Results: The API doesn't have enough questions for your query.",
            2 => "Invalid Parameter: Contains an invalid parameter. Arguments passed in aren't valid.",
            3 => "Token Not Found: Session Token does not exist.",
            4 => "Token Empty: Session Token has returned all possible questions for the specified query. Resetting the Token is necessary.",
            5 => "Rate Limit: Too many requests have occurred."
        ];
        // Display error message if required
        $error_code = $data['response_code'];
        if (isset($error_messages[$error_code])) {
            echo "An error occurred: " . $error_messages[$error_code] . " (Error Code: $error_code)";
        } else {
            echo "An unknown error occurred. (Error Code: $error_code)";
        }
    }
    ?>

<script>
    function revealAnswer(cell) {
        // Get the correct answer from PHP
        var correctAnswer = "<?php echo $correctAnswer; ?>";
        
        // Check if the cell's text content matches the correct answer
        if (cell.textContent.trim() === correctAnswer.trim()) {
            cell.style.backgroundColor = "green"; // Correct answer
        } else {
            cell.style.backgroundColor = "red"; // Incorrect answer
        }
    }
</script>

</body>
</html>
