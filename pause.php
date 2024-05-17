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
    <title>Setup Trivia</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/playeradd.css"> 
    <link rel="stylesheet" href="Styles/setup.css"> 
    <style>
        .answer {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
            width: 15vw;
            margin-left: auto;
            margin-right: auto;
        }
        .downloads {
            margin-top: auto;
            margin-bottom: auto;
            display: flex;
            flex-direction: column;
        }
        .downloads h1 {
            max-width: 30vw;
        }
        .downloads h3 {
            max-width: 30vw;
            margin-top: 0px;
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
            <div class="downloads">
                <h1>All questions finished!</h1>
                <h3>Please hand in your completed answer sheets to the host.</h3>
                <a href="answers.php?id=<?php echo $id; ?>" class="answer">View Answers</a>
            </div>
            
        </div>
    </div>
</body>
</html>
