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

// Initialize variables
$game_name = "";
$team1_name = "";
$team2_name = "";
$team3_name = "";
$team4_name = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_id = $_POST['game_id'];
    $team1_score = isset($_POST['team1_score']) ? $_POST['team1_score'] : 0;
    $team2_score = isset($_POST['team2_score']) ? $_POST['team2_score'] : 0;
    $team3_score = isset($_POST['team3_score']) ? $_POST['team3_score'] : 0;
    $team4_score = isset($_POST['team4_score']) ? $_POST['team4_score'] : 0;

    // Fetch current scores from the database
    $sql = "SELECT team1Score, team2Score, team3Score, team4Score FROM teams WHERE game_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_scores = $result->fetch_assoc();

    // Calculate new scores by adding the entered scores to the current scores
    $new_team1_score = $current_scores['team1Score'] + $team1_score;
    $new_team2_score = $current_scores['team2Score'] + $team2_score;
    $new_team3_score = $current_scores['team3Score'] + $team3_score;
    $new_team4_score = $current_scores['team4Score'] + $team4_score;

    // Update scores in the database
    $sql = "UPDATE teams SET team1Score = ?, team2Score = ?, team3Score = ?, team4Score = ? WHERE game_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiii", $new_team1_score, $new_team2_score, $new_team3_score, $new_team4_score, $game_id);

    if ($stmt->execute()) {
        // Redirect to final.php after successful update
        header("Location: final.php?id=$game_id");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Fetch game details from the database based on the provided game ID
    $sql = "SELECT gameName, team1Name, team2Name, team3Name, team4Name FROM teams WHERE game_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows > 0) {
        // Fetch the game details
        $row = $result->fetch_assoc();
        $game_name = $row["gameName"];
        $team1_name = $row["team1Name"];
        $team2_name = $row["team2Name"];
        $team3_name = $row["team3Name"];
        $team4_name = $row["team4Name"];
    } else {
        // Handle case where no game was found for the provided ID
        $game_name = "Game Not Found";
        $team1_name = $team2_name = $team3_name = $team4_name = "N/A";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Scores</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/playeradd.css">
    <link rel="stylesheet" href="Styles/setup.css">
    <style>
        .team-input {
            margin-bottom: 20px;
        }
        .team-container form {
            width: 100%;
        }
        .team-container {
            max-width: 600px; /* Adjust the width to fit your design */
            margin: 0 auto;
            margin-top: auto;
            margin-bottom: auto;
        }
        .team-container h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="black-square">
            <div class="game-details">
                <h2>Game Name: <?php echo htmlspecialchars($game_name); ?></h2>
                <h2>Game ID: <?php echo htmlspecialchars($id); ?></h2>
            </div>
            <div class="team-container">
                <h1>Enter Scores!</h1>
                <form action="" method="POST">
                    <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($id); ?>">
                    <?php if (!empty($team1_name) && $team1_name !== "N/A"): ?>
                        <div class="team-input">
                            <label for="team1_score"><?php echo htmlspecialchars($team1_name); ?>:</label><br>
                            <input type="number" id="team1_score" name="team1_score" required><br>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($team2_name) && $team2_name !== "N/A"): ?>
                        <div class="team-input">
                            <label for="team2_score"><?php echo htmlspecialchars($team2_name); ?>:</label><br>
                            <input type="number" id="team2_score" name="team2_score" required><br>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($team3_name) && $team3_name !== "N/A"): ?>
                        <div class="team-input">
                            <label for="team3_score"><?php echo htmlspecialchars($team3_name); ?>:</label><br>
                            <input type="number" id="team3_score" name="team3_score" required><br>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($team4_name) && $team4_name !== "N/A"): ?>
                        <div class="team-input">
                            <label for="team4_score"><?php echo htmlspecialchars($team4_name); ?>:</label><br>
                            <input type="number" id="team4_score" name="team4_score" required><br>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="">Submit</button>
                </form>
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
</body>
</html>
