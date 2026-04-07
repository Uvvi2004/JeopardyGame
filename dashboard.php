<?php
include 'includes/session.php';
check_login();
?>

<!DOCTYPE html>
<html>
<body>
<h2>Dashboard</h2>

<p>Welcome <?php echo $_SESSION['user']; ?></p>

<a href="game.php">Start Game</a><br>
<a href="leaderboard.php">Leaderboard</a><br>
<a href="logout.php">Logout</a>

</body>
</html>
