<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

ini_set('display_errors', 0);

// reset game
if (isset($_POST['reset'])) {
    $_SESSION['score'] = 0;
    $_SESSION['used_questions'] = [];
}

// init used questions
if (!isset($_SESSION['used_questions'])) {
    $_SESSION['used_questions'] = [];
}

// count total questions
$totalQuestions = 0;
foreach ($questions as $qs) {
    $totalQuestions += count($qs);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Jeopardy Game</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="game-body">

    <h1 class="game-title">Jeopardy Game</h1>

    <h3 class="game-score">Score: <?php echo $_SESSION['score'] ?? 0; ?></h3>

    <form method="POST">
        <button type="submit" name="reset" class="btn btn-ghost btn-sm">Reset Game</button>
    </form>

    <?php if (count($_SESSION['used_questions']) === $totalQuestions): ?>
        <h2 class="game-over-banner">Game Over!</h2>
        <p>Final Score: <?php echo $_SESSION['score'] ?? 0; ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="20" class="board-table">

        <tr>
            <?php foreach ($questions as $category => $qs): ?>
                <th><?php echo htmlspecialchars($category); ?></th>
            <?php endforeach; ?>
        </tr>

        <?php for ($i = 0; $i < 4; $i++): ?>
            <tr>
                <?php foreach ($questions as $category => $qs): ?>
                    <td>
                        <?php if (isset($qs[$i])): ?>
                            <?php if (!in_array($qs[$i]['id'], $_SESSION['used_questions'])): ?>
                                <form action="question.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $qs[$i]['id']; ?>">
                                    <button type="submit" class="point-btn">
                                        <?php echo $qs[$i]['points']; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="cell-used">✔</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>

    </table>

    <br>
    <a href="dashboard.php" class="btn btn-ghost btn-sm">Back</a>

</body>

</html>