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
        /* Add any additional styles here */
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
                    echo "<h2 class='question'>" . ($currentIndex + 1) . ". " . htmlspecialchars_decode($question['question']) . "</h2>";
                    echo "<button class='next-button' id='nextButton'>Next</button>"; // Next button
                    echo "</div>";
                    echo "<div class='answer-grid'>";

                    // Extracting correct and incorrect answers
                    $correctAnswer = htmlspecialchars_decode($question['correct_answer']);
                    $incorrectAnswers = array_map('htmlspecialchars_decode', $question['incorrect_answers']);

                    // Combining correct and incorrect answers
                    $allAnswers = array_merge([$correctAnswer], $incorrectAnswers);

                    // Shuffle the combined answers
                    shuffle($allAnswers);

                    // Display answer choices
                    foreach ($allAnswers as $answer) {
                        echo "<div class='answer-button'>$answer</div>";
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
                document.querySelector('.question').innerHTML = (currentIndex + 1) + ". " + nextQuestion.question;

                // Extract answer choices
                let correctAnswer = htmlspecialchars_decode(nextQuestion.correct_answer);
                let incorrectAnswers = nextQuestion.incorrect_answers.map(function(answer) {
                    return htmlspecialchars_decode(answer);
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
                
                // You can also redirect to the end page if needed
                window.location.href = 'answers.php?id=$game_id';
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

        function htmlspecialchars_decode(str) {
            return str.replace(/&quot;/g, '"')
                      .replace(/&amp;/g, '&')
                      .replace(/&lt;/g, '<')
                      .replace(/&gt;/g, '>')
                      .replace(/&apos;/g, "'");
        }

        document.getElementById('nextButton').addEventListener('click', loadNextQuestion);
    </script>
</body>
</html>
