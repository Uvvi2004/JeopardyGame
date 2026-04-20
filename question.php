<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

ini_set('display_errors', 0);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$selectedQuestion = null;

foreach ($questions as $category => $qs) {
    foreach ($qs as $q) {
        if ($q['id'] === $id) {
            $selectedQuestion = $q;
            break 2;
        }
    }
}

if (!$selectedQuestion) {
    echo "Question not found";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Question</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="question-body">
    <div class="auth-bg">
        <div class="bg-grid"></div>
        <div class="bg-glow"></div>
    </div>
    <div class="question-wrapper">
        <h2 class="question-label">Question</h2>

        <p class="question-text"><?php echo htmlspecialchars($selectedQuestion['q']); ?></p>

        <form action="result.php" method="POST" class="auth-form">
            <input type="hidden" name="id" value="<?php echo $selectedQuestion['id']; ?>">
            <div class="form-group">
                <input type="text" name="answer" id="answer" class="form-input" placeholder="Your answer" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary btn-full">
                Submit<span class="btn-arrow">→</span>
            </button>
        </form>
    </div>
    <br>
    <a href="game.php" class="btn btn-ghost btn-sm">Back to Game</a>

</body>

</html>