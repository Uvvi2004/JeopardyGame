<?php
require_once 'includes/session.php';
check_login();

// get scores
$scores = $_SESSION['scores'] ?? [];

// sort highest first
usort($scores, function($a, $b) {
    return $b['score'] <=> $a['score'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
</head>
<body>

<h1>Leaderboard</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Rank</th>
        <th>User</th>
        <th>Score</th>
    </tr>

    <?php foreach ($scores as $index => $entry): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($entry['user']); ?></td>
            <td><?php echo $entry['score']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="dashboard.php">Back</a>

</body>
</html>