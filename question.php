<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

// get question id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$selectedQuestion = null;

// find question by id
foreach ($questions as $category => $qs) {
    foreach ($qs as $q) {
        if ($q['id'] === $id) {
            $selectedQuestion = $q;
            break 2;
        }
    }
}

// if not found
if (!$selectedQuestion) {
    echo "Question not found";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Question</title>
</head>
<body>

<h2>Question</h2>

<p><?php echo htmlspecialchars($selectedQuestion['q']); ?></p>

<form action="result.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $selectedQuestion['id']; ?>">
    
    <input type="text" name="answer" placeholder="Your answer">
    
    <button type="submit">Submit</button>
</form>

<br>
<a href="game.php">Back to Game</a>

</body>
</html>