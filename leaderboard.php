<?php
require_once 'includes/session.php';
check_login();

ini_set('display_errors', 0);

$file = 'data/scores.txt';

$scores = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $scores = json_decode($json, true) ?? [];
}

// sort high → low
usort($scores, function ($a, $b) {
    return $b['score'] <=> $a['score'];
});

// top 10
$scores = array_slice($scores, 0, 10);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="leaderboard-body">

    <h1>Leaderboard</h1>

    <table border="1" cellpadding="10" class="leaderboard-table">
        <tr>
            <th>Rank</th>
            <th>User</th>
            <th>Score</th>
        </tr>

        <?php foreach ($scores as $index => $entry): ?>
            <tr class="<?php echo $index < 3 ? 'top-row' : ''; ?>">
                <td class="rank-cell rank-<?php echo $index + 1; ?>">
                    <?php
                    if ($index === 0) echo '🥇';
                    elseif ($index === 1) echo '🥈';
                    elseif ($index === 2) echo '🥉';
                    else echo $index + 1;
                    ?>
                </td>
                <td><?php echo htmlspecialchars($entry['user']); ?></td>
                <td><?php echo $entry['score']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="dashboard.php">Back</a>

</body>

</html>