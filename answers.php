<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Answers</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/playeradd.css"> 
    <link rel="stylesheet" href="Styles/setup.css"> 
    <style>
        .navigation-buttons {
            display: flex;
            justify-content: center; /* Center align the navigation buttons */
            gap: 10px; /* Add space between buttons if needed */
            margin-bottom: 20px;
        }
        .button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .question {
            margin-bottom: 20px;
            text-align: left; /* Left align the question text */
        }
        .correct {
            margin-top: 10px; /* Adjust this value to increase or decrease the gap */
        }
        .center {
            margin-top: auto;
            margin-bottom: auto;
            text-align: center; /* Center align the text inside the div */
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 30vw;
        }
        .center h1 {
            text-align: center; /* Center align the h1 */
        }
        .center .question-container {
            width: 100%; /* Ensure the container takes full width */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="black-square">
            
            <div class="game-details">
                <h2>Game Name: <?php echo $game_name; ?></h2>
                <h2> Game ID: <?php echo $id; ?></h2>
            </div>
            <div class="center">
            <h1>Answers</h1>
            <div class="navigation-buttons">
                <button id="back-button" class="button" onclick="navigate(-1)">Back</button>
                <button id="next-button" class="button" onclick="navigate(1)">Next</button>
            </div>
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

                        // Display questions with their respective numbers and correct answers
                        echo '<div id="questions-container">';
                        foreach ($api_data_decoded['results'] as $index => $question) {
                            $questionNumber = $index + 1;
                            $questionText = htmlspecialchars_decode($question['question']);
                            $correctAnswer = htmlspecialchars_decode($question['correct_answer']);

                            echo "<div class='question' data-index='$index'><p class='correct'><strong>$questionNumber. $questionText</strong></p>";
                            echo "</br>";
                            echo "<p style='margin-top:10px;'>$correctAnswer</p></div>";
                        }
                        echo '</div>';
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
            <div class="footer-links">
                <a href="#" class="white-text-link">Help</a> 
                <p class="copyright"> | </p>
                <a href="#" class="white-text-link">Privacy Policy</a> 
                <p class="copyright"> | </p>
                <p class="copyright">© Tasha Barbaro 2024</p>
            </div>
        </div>
    </div>
    <script>
    const questionsPerPage = 5;
    let currentPage = 0;

    function showPage(page) {
        const questions = document.querySelectorAll('.question');
        const totalPages = Math.ceil(questions.length / questionsPerPage);
        
        if (page < 0) page = 0;
        if (page >= totalPages) page = totalPages - 1;

        questions.forEach((question, index) => {
            question.style.display = (index >= page * questionsPerPage && index < (page + 1) * questionsPerPage) ? 'block' : 'none';
        });

        document.getElementById('back-button').disabled = page === 0;
        document.getElementById('next-button').disabled = false; // Enable the "Next" button by default

        currentPage = page;
    }

    function navigate(direction) {
        const questions = document.querySelectorAll('.question');
        const totalPages = Math.ceil(questions.length / questionsPerPage);
        const nextPage = currentPage + direction;

        if (nextPage >= totalPages) {
            window.location.href = 'input.php'; // Redirect to input.php if next page exceeds total pages
        } else {
            showPage(nextPage); // Show next page of questions
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        showPage(0);
    });
</script>

</body>
</html>
