<?php
// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $game_id = $_GET['id']; // Retrieve game ID from URL query parameter
    $num_questions = $_POST['num_questions'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];

    // Echo out the submitted data
    echo "Game ID: " . $game_id . "<br>";
    echo "Number of Questions: " . $num_questions . "<br>";
    echo "Category: " . $category . "<br>";
    echo "Difficulty: " . $difficulty . "<br>";
} else {
    // If form data is not submitted, display an error message
    echo "Form data not submitted.";
}
?>
