<?php
require_once 'includes/session.php';
check_login();

require_once 'data/questions.php';

// turn off warnings showing on screen
ini_set('display_errors', 0);
error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jeopardy Game</title>
</head>
<body>

<h1>Jeopardy Game</h1>

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
                <form action="question.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($qs[$i]['id']); ?>">
                    <button type="submit">
                        <?php echo htmlspecialchars($qs[$i]['points']); ?>
                    </button>
                </form>
            <?php else: ?>
                -
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