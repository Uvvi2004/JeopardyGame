<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

// initialize score if not set
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

// get data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$userAnswer = isset($_POST['answer']) ? trim($_POST['answer']) : '';

$selectedQuestion = null;

// find question
foreach ($questions as $category => $qs) {
    foreach ($qs as $q) {
        if ($q['id'] === $id) {
            $selectedQuestion = $q;
            break 2;
        }
    }
}

// safety check
if (!$selectedQuestion) {
    echo "Question not found";
    exit();
}

// check answer (case insensitive)
$isCorrect = strtolower($userAnswer) === strtolower($selectedQuestion['a']);

// update score
if ($isCorrect) {
    $_SESSION['score'] += $selectedQuestion['points'];
} else {
    $_SESSION['score'] -= $selectedQuestion['points'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
</head>
<body>

<h2>Result</h2>

<p>Your Answer: <?php echo htmlspecialchars($userAnswer); ?></p>
<p>Correct Answer: <?php echo htmlspecialchars($selectedQuestion['a']); ?></p>

<?php if ($isCorrect): ?>
    <p style="color:green;">Correct! +<?php echo $selectedQuestion['points']; ?></p>
<?php else: ?>
    <p style="color:red;">Wrong! -<?php echo $selectedQuestion['points']; ?></p>
<?php endif; ?>

<h3>Your Score: <?php echo $_SESSION['score']; ?></h3>

<br>
<a href="game.php">Back to Game</a>

</body>
</html>