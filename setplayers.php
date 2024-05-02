<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Team Names</title>
    <link rel="stylesheet" href="Styles/main.css">
    <link rel="stylesheet" href="Styles/leaderboard.css">
    <link rel="stylesheet" href="Styles/playeradd.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tilt+Neon&display=swap" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <div class="black-square">
            <h1 class="title">Online Trivia</h1>
            <form method="POST" action="processing/addplayer.php">
                <div class="team-container">
                    <label for="game_name">Game Name:</label>
                    <input type="text" id="game_code" name="game_code" placeholder="Enter 4 digit game code*" required>
                </div>
                <div class="team-container">
                    <label for="game_code">Game Code:</label>
                    <input type="text" id="game_name" name="game_name" placeholder="Enter game name*" required>
                </div>
                <div class="team-container">
                    <label for="team1_name">Team 1 Name:</label>
                    <input type="text" id="team1_name" name="team1_name" placeholder="Enter team 1 name*" required>
                </div>
                <div class="team-container">
                    <label for="team2_name">Team 2 Name:</label>
                    <input type="text" id="team2_name" name="team2_name" placeholder="Enter team 2 name*" required>
                </div>
                <div class="team-container">
                    <label for="team3_name">Team 3 Name:</label>
                    <input type="text" id="team3_name" name="team3_name" placeholder="Enter team 3 name">
                </div>
                <div class="team-container">
                    <label for="team4_name">Team 4 Name:</label>
                    <input type="text" id="team4_name" name="team4_name" placeholder="Enter team 4 name" >
                </div>
                <div class="team-container">
                    <button type="submit">Submit</button>
                </div>
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
