<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

ini_set('display_errors', 0);

// init score
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

// init used questions
if (!isset($_SESSION['used_questions'])) {
    $_SESSION['used_questions'] = [];
}

// get data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$userAnswer = isset($_POST['answer']) ? trim($_POST['answer']) : '';

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

// mark used safely
if (!in_array($id, $_SESSION['used_questions'])) {
    $_SESSION['used_questions'][] = $id;
}

// check answer
$isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($selectedQuestion['a']));

// update score
if ($isCorrect) {
    $_SESSION['score'] += $selectedQuestion['points'];
} else {
    $_SESSION['score'] -= $selectedQuestion['points'];
}

//
// 🔥 SAVE TO FILE (PERSISTENT LEADERBOARD)
//
$file = 'data/scores.txt';

$scores = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $scores = json_decode($json, true) ?? [];
}

// add new score
$scores[] = [
    "user" => $_SESSION['user'],
    "score" => $_SESSION['score']
];

// save back
file_put_contents($file, json_encode($scores));
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