<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trivia Questions</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
</head>
<body>
    <div class="container">
        <div class="black-square">
        <?php
            session_start();

            // Check if API data is stored in session
            if(isset($_SESSION['api_data'])) {
                // Retrieve API data from session
                $api_data = $_SESSION['api_data'];

                // Decode JSON data
                $api_data_decoded = json_decode($api_data, true);
                
                // Display questions here
                echo "<pre>";
                print_r($api_data_decoded);
                echo "</pre>";
            } else {
                echo "No data found.";
            }
        ?>

        </div>
        
    </div>
</body>
</html>
