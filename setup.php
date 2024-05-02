<?php
// Receive the auto-incremented key and game name from the URL
$id = $_GET['id'];
$game_name = $_GET['game_name'];
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
    <style>
        .game-details {
            display: inline-block;
            font-size: 14px;
            margin-top: 20px;
            color: #fff;
        }
        .team-container button {
            margin: 0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="black-square">
            <h1 class="title">Online Trivia</h1>
            <div class="game-details">
                <h2>Game Name: <?php echo $game_name; ?> Game ID: <?php echo $id; ?></h2>
            </div>
            <form action="pulldata.php" method="post" class="team-container">
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
