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

                // Display questions
                if(isset($api_data_decoded['results'][0])) {
                    $question = $api_data_decoded['results'][0];
                    echo "<div class='question-container'>";
                    echo "<h2 class='question'>" . htmlspecialchars_decode($question['question']) . "</h2>";
                    echo "<button class='next-button' onclick='loadNextQuestion()'>Next</button>"; // Next button
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
                        echo "<div class='answer-button' onclick='revealAnswer(this)'>$answer</div>";
                    }
                    
                    echo "</div>";
                } else {
                    echo "No questions found.";
                }
            } else {
                echo "Error: No data found.";
            }
            ?>
        </div>
    </div>

    <script>
        function revealAnswer(button) {
            var correctAnswer = "<?php echo isset($correctAnswer) ? $correctAnswer : ''; ?>";
            var answerButtons = document.querySelectorAll('.answer-button');
            answerButtons.forEach(function(btn) {
                if (btn.textContent.trim() === correctAnswer.trim()) {
                    btn.style.backgroundColor = "green"; // Correct answer
                } else {
                    btn.style.backgroundColor = "red"; // Incorrect answer
                }
            });
        }

        function loadNextQuestion() {
    // Fetch the session data containing all questions
    var apiData = <?php echo json_encode($_SESSION['api_data']); ?>;
    
    // Decode the JSON data
    var apiDataDecoded = JSON.parse(apiData);
    
    // Check if there are more questions available
    var currentIndex = <?php echo isset($currentIndex) ? $currentIndex : 0; ?>;
    var totalQuestions = apiDataDecoded.results.length;
    
    if (currentIndex < totalQuestions - 1) {
        // Increment the index to get the next question
        var nextQuestion = apiDataDecoded.results[currentIndex + 1];
        
        // Update the HTML content with the next question and answer choices
        document.querySelector('.question').innerHTML = nextQuestion.question;
        
        // Extract answer choices
        var correctAnswer = nextQuestion.correct_answer;
        var incorrectAnswers = nextQuestion.incorrect_answers;
        var allAnswers = [correctAnswer, ...incorrectAnswers];
        shuffleArray(allAnswers); // Shuffle the answer choices
        
        var answerButtons = document.querySelectorAll('.answer-button');
        answerButtons
    }}
    </script>
</body>
</html>
