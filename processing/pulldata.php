<?php
// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $game_id = $_GET['id']; // Retrieve game ID from URL query parameter
    $num_questions = $_POST['num_questions'];
    $category_name = $_POST['category'];
    $difficulty = strtolower($_POST['difficulty']); // Convert difficulty to lowercase

    // Connect to your database
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

    // Query the database to get the category code
    $sql = "SELECT Number FROM Categories WHERE Category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $category_number = $row['Number'];

    // Close database connection
    $stmt->close();
    $conn->close();

    // Construct the API URL
    $api_url = "https://opentdb.com/api.php?amount=$num_questions&category=$category_number&difficulty=$difficulty";

    // Fetch data from the API URL
    $api_data = file_get_contents($api_url);

    // Check if data is fetched successfully
    if ($api_data !== false) {
        // Start session
        session_start();

        // Store API data in session
        $_SESSION['api_data'] = $api_data;

        // Redirect to question.php
        header("Location: ../question.php?id=$game_id");
        exit;
    } else {
        // If data fetching fails, display an error message
        echo "Failed to fetch data from API.";
    }
} else {
    // If form data is not submitted, display an error message
    echo "Form data not submitted.";
}
?>
