<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

// initialize used questions
if (!isset($_SESSION['used_questions'])) {
    $_SESSION['used_questions'] = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jeopardy Game</title>
</head>
<body>

<h1>Jeopardy Game</h1>

<h3>Score: <?php echo $_SESSION['score'] ?? 0; ?></h3>

<table border="1" cellpadding="20">

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
                        <button type="submit">
                            <?php echo $qs[$i]['points']; ?>
                        </button>
                    </form>
                <?php else: ?>
                    ✔
                <?php endif; ?>
            <?php endif; ?>
        </td>
    <?php endforeach; ?>
</tr>
<?php endfor; ?>

</table>

<br>
<a href="dashboard.php">Back</a>

</body>
</html>