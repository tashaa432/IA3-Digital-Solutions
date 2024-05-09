<?php
// Database connection parameters
$servername = "localhost";
    $username = "root";
    $password = "_fIpGeMVe[(.sRtb";
    $dbname = "trivia";

// Receive the auto-incremented key from the URL
$id = $_GET['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch game name from the database based on the provided game ID
$sql = "SELECT gameName FROM teams WHERE game_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if a row was returned
if ($result->num_rows > 0) {
    // Fetch the game name
    $row = $result->fetch_assoc();
    $game_name = $row["gameName"];
} else {
    // Handle case where no game was found for the provided ID
    $game_name = "Game Not Found";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trivia Questions - Answers</title>
</head>
<body>
    <h1>Trivia Questions - Answers</h1>
    <div class="game-details">
                <h2>Game Name: <?php echo $game_name; ?></h2>
                <h2> Game ID: <?php echo $id; ?></h2>
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
            foreach ($api_data_decoded['results'] as $index => $question) {
                $questionNumber = $index + 1;
                $questionText = htmlspecialchars_decode($question['question']);
                $correctAnswer = htmlspecialchars_decode($question['correct_answer']);

                echo "<p><strong>$questionNumber. $questionText</strong></p>";
                echo "<p>Correct Answer: $correctAnswer</p>";
            }
        } else {
            echo "Error: 'results' key not found in API data.";
            exit; // Stop script execution
        }
    } else {
        echo "Error: No API data found in session.";
        exit; // Stop script execution
    }
    ?>
</body>
</html>
