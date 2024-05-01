<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tilt+Neon&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="black-square">
            <h1 class="title">Leaderboard</h1>
            <form method="GET">
                <div class="input-container">
                    <input type="text" name="game_code" placeholder="Enter game code">
                    <button type="submit">Submit</button>
                </div>
            </form>
            <?php
            // Establish connection to the SQL database
            $servername = "localhost";
            $username = "root";
            $password = "_fIpGeMVe[(.sRtb";
            $dbname = "trivia";

            // Check if form submitted
            if(isset($_GET['game_code'])) {
                // Fetch game code from form submission
                $game_code = $_GET['game_code'];

                // Establish connection to the SQL database
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and execute SQL query
                $query = "SELECT team1Name, team1Score, team2Name, team2Score, team3Name, team3Score FROM teams WHERE game_code = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $game_code);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if data is received
                if ($result->num_rows === 0) {
                    echo '<div class="leaderboard-message">No data found for game code: ' . $game_code . '</div>';
                } else {
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
                    }

                    // Sort leaderboard by score in descending order
                    usort($leaderboard, function($a, $b) {
                        return $b[1] - $a[1];
                    });

                    // Display leaderboard entries
                    echo '<div class="leaderboard">';
                    for ($i = 0; $i < min(count($leaderboard), 3); $i++) {
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
                                $trophy = '';
                        }
                        echo '<div class="leaderboard-entry">' . $trophy . ' ' . $leaderboard[$i][0] . ': ' . $leaderboard[$i][1] . '</div>';
                    }
                    echo '</div>';
                }

                // Close connection
                $stmt->close();
                $conn->close();
            }
            ?>
            <div class="button-container">
                <a href="index.html" class="button">Home</a>
                <a href="index.html" class="button">New Game</a>
            </div>

        </div>
        
    </div>
</body>
</html>
