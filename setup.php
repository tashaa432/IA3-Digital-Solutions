<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <title>Setup Trivia</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/playeradd.css"> 
    <link rel="stylesheet" href="Styles/setup.css"> 
</head>
<body>
    <div class="container">
        <div class="black-square">
            <h1 class="title">Online Trivia</h1>
            <div class="game-details">
                <h2>Game Name: <?php echo $game_name; ?></h2>
                <h2> Game ID: <?php echo $id; ?></h2>
            </div>
            <form action="processing/pulldata.php?id=<?php echo $id; ?>" method="post" class="team-container">
                <label for="num_questions">Number of Questions:</label>
                <select id="num_questions" name="num_questions">
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
                <br><br>
                
                <label for="category">Question Categories:</label>
                <select id="category" name="category">
                    <option value="General Knowledge">General Knowledge</option>
                    <option value="Science and Nature">Science and Nature</option>
                    <option value="Sports">Sports</option>
                    <option value="Celebrities">Celebrities</option>
                    <option value="History">History</option>
                </select>
                <br><br>

                <label for="difficulty">Question Difficulty:</label>
                <select id="difficulty" name="difficulty">
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                </select>
                <br><br>

                <button type="submit">Submit</button>
            </form>
            <div class="footer-links">
                <a href="#" class="white-text-link">Help</a> 
                <p class="copyright"> | </p>
                <a href="#" class="white-text-link">Privacy Policy</a> 
                <p class="copyright"> | </p>
                <p class="copyright">© Tasha Barbaro 2024</p>
            </div>
        </div>
    </div>
</body>
</html>
