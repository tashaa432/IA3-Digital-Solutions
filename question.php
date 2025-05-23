<?php
// Receive the auto-incremented key from the URL
$game_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trivia Questions</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/question.css">
    <style>
        /* Define unique classes for each answer button */
        .answer-button-1 {
            background-color: #BE5B4E; /* Red */
        }

        .answer-button-2 {
            background-color: #B673C1; /* Green */
        }

        .answer-button-3 {
            background-color: #7488C1; /* Green */
        }

        .answer-button-4 {
            background-color: #64BF60; /* Green */
        }

        /* Add more classes for additional buttons as needed */
    </style>
</head>
<body>
    <div class="container">
        <div class="black-square">
            <?php
            session_start();

            // Check if API data is stored in session
            if(isset($_SESSION['api_data'])) {
                // Retrieve API data from session
                $api_data = $_SESSION['api_data'];
                
                // Decode JSON data
                $api_data_decoded = json_decode($api_data, true);
                
                // Check if decoding was successful
                if ($api_data_decoded === null && json_last_error() !== JSON_ERROR_NONE) {
                    // Handle JSON decoding error
                    echo "Error decoding JSON data: " . json_last_error_msg();
                    exit; // Stop script execution
                }

                // Check if 'results' key exists in the decoded data
                if(isset($api_data_decoded['results'])) {
                    $totalQuestions = count($api_data_decoded['results']);
                    $currentIndex = isset($_SESSION['currentIndex']) ? $_SESSION['currentIndex'] : 0;
                    
                    // Check if current index is within the bounds of available questions
                    if ($currentIndex >= $totalQuestions) {
                        // Reset index to zero
                        $currentIndex = 0;
                    }

                    $question = $api_data_decoded['results'][$currentIndex];
                    echo "<div class='question-container'>";
                    echo "<h2 class='question'>" . ($currentIndex + 1) . ". " . htmlspecialchars_decode($question['question'], ENT_QUOTES) . "</h2>";
                    echo "<button class='next-button' id='nextButton'>Next</button>"; // Next button
                    echo "</div>";
                    echo "<div class='answer-grid'>";

                    // Extracting correct and incorrect answers
                    $correctAnswer = htmlspecialchars_decode($question['correct_answer'], ENT_QUOTES);
                    $incorrectAnswers = array_map(function($answer) {
                        return htmlspecialchars_decode($answer, ENT_QUOTES);
                    }, $question['incorrect_answers']);

                    // Combining correct and incorrect answers
                    $allAnswers = array_merge([$correctAnswer], $incorrectAnswers);

                    // Shuffle the combined answers
                    shuffle($allAnswers);

                    // Display answer choices
                    foreach ($allAnswers as $index => $answer) {
                        $button_class = "answer-button answer-button-" . ($index + 1);
                        echo "<div class='$button_class'>" . htmlspecialchars($answer, ENT_QUOTES) . "</div>";
                    }

                    echo "</div>";
                } else {
                    echo "Error: 'results' key not found in API data.";
                    exit; // Stop script execution
                }
            } else {
                echo "Error: No API data found in session.";
                exit; // Stop script execution
            }
            ?>
        </div>
    </div>

    <script>
        let apiData = <?php echo json_encode($_SESSION['api_data']); ?>;
        let apiDataDecoded = JSON.parse(apiData);
        let totalQuestions = apiDataDecoded.results.length;
        let currentIndex = <?php echo $currentIndex; ?>;

        function loadNextQuestion() {
            if (currentIndex < totalQuestions - 1) {
                currentIndex++;
                let nextQuestion = apiDataDecoded.results[currentIndex];

                // Update the HTML content with the next question and answer choices
                document.querySelector('.question').innerHTML = (currentIndex + 1) + ". " + decodeHTMLEntities(nextQuestion.question);

                // Extract answer choices
                let correctAnswer = decodeHTMLEntities(nextQuestion.correct_answer);
                let incorrectAnswers = nextQuestion.incorrect_answers.map(function(answer) {
                    return decodeHTMLEntities(answer);
                });

                let allAnswers = [correctAnswer, ...incorrectAnswers];

                // Shuffle the combined answers
                allAnswers = shuffle(allAnswers);

                let answerButtons = document.querySelectorAll('.answer-button');
                answerButtons.forEach(function(btn, index) {
                    btn.textContent = allAnswers[index];
                });

                // Update the index for the next question
                <?php $_SESSION['currentIndex'] = $currentIndex + 1; ?>
            } else {
                // If no more questions available, display a message
                window.location.href = 'pause.php?id=<?php echo $game_id; ?>';
                document.getElementById('nextButton').disabled = true;
            }
        }

        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function decodeHTMLEntities(text) {
            let parser = new DOMParser();
            let dom = parser.parseFromString('<!doctype html><body>' + text, 'text/html');
            return dom.body.textContent;
        }

        document.getElementById('nextButton').addEventListener('click', loadNextQuestion);
    </script>
</body>
</html>
