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
    <title>Leaderboard</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/setup.css">
    <style>
        .leaderboardd {
            margin-top: 12vh;
        }
        .gameName {
            text-align: center;
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
            <h1 class="title">Leaderboard</h1>
            <div class="leaderboardd">
            <?php
    // Establish connection to the SQL database
    $servername = "localhost";
    $username = "root";
    $password = "_fIpGeMVe[(.sRtb";
    $dbname = "trivia";

    // Fetch game code from URL query parameter
    if(isset($_GET['id'])) {
        $game_code = $_GET['id'];

        // Establish connection to the SQL database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL query
        $query = "SELECT gameName, team1Name, team1Score, team2Name, team2Score, team3Name, team3Score, team4Name, team4Score FROM teams WHERE game_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $game_code);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if data is received
        if ($result->num_rows === 0) {
            echo '<div class="leaderboard-message">No data found for game code: ' . $game_code . '</div>';
        } else {
            // Fetch game name
            $row = $result->fetch_assoc();
            $gameName = $row['gameName'];

            // Display game name
            echo '<h2 class="gameName">' . $gameName . '</h2>';

            // Reset result pointer to the beginning
            $result->data_seek(0);

            // Process retrieved data for leaderboard
            $leaderboard = [];
            while($row = $result->fetch_assoc()) {
                if (!empty($row["team1Name"])) {
                    $leaderboard[] = [$row["team1Name"], $row["team1Score"]];
                }
                if (!empty($row["team2Name"])) {
                    $leaderboard[] = [$row["team2Name"], $row["team2Score"]];
                }
                if (!empty($row["team3Name"])) {
                    $leaderboard[] = [$row["team3Name"], $row["team3Score"]];
                }
                if (!empty($row["team4Name"])) {
                    $leaderboard[] = [$row["team4Name"], $row["team4Score"]];
                }
            }

            // Sort leaderboard by score in descending order
            usort($leaderboard, function($a, $b) {
                return $b[1] - $a[1];
            });

            // Display leaderboard entries
            echo '<div class="leaderboard">';
            for ($i = 0; $i < min(count($leaderboard), 4); $i++) {
                $trophy = '';
                switch ($i) {
                    case 0:
                        $trophy = '🥇';
                        break;
                    case 1:
                        $trophy = '🥈';
                        break;
                    case 2:
                        $trophy = '🥉';
                        break;
                    default:
                        $trophy = '💩';
                }
                echo '<div class="leaderboard-entry">' . $trophy . ' ' . $leaderboard[$i][0] . ': ' . $leaderboard[$i][1] . '</div>';
            }
            echo '</div>';
        }

        // Close connection
        $stmt->close();
        $conn->close();
    } else {
        echo '<div class="leaderboard-message">No game code provided in the URL.</div>';
    }
    ?>
    </div>
            <div class="button-container">
                <a href="index.html" class="button">Home</a>
                <a href="setup.php?id=<?php echo $game_code; ?>" class="button">Play Again</a>
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
