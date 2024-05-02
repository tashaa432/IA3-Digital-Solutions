<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $game_name = $_POST["game_name"];
    $game_code = $_POST["game_code"];
    $team1_name = $_POST["team1_name"];
    $team2_name = $_POST["team2_name"];
    $team3_name = $_POST["team3_name"];
    $team4_name = $_POST["team4_name"];

    // Connect to your database (replace these with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "_fIpGeMVe[(.sRtb";
    $dbname = "trivia";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO teams (gameName, team1Name, team2Name, team3Name, team4Name)
            VALUES ('$game_name', '$team1_name', '$team2_name', '$team3_name', '$team4_name')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Data added to database, redirecting!";
        // Redirect to another page
        header("Location: ../setup.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}

