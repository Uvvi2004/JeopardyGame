<?php
include 'includes/session.php';
check_login();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy! — Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <h2>Dashboard</h2>

    <p>Welcome <?php echo $_SESSION['user']; ?></p>

    <a href="game.php">Start Game</a><br>
    <a href="leaderboard.php">Leaderboard</a><br>
    <a href="logout.php">Logout</a>

</body>

</html>