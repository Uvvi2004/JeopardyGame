<?php
include 'includes/session.php';
?>

<!DOCTYPE html>
<html>

<body>
	<h2>Login Page</h2>
	<form method="POST">
		Username: <input type="text" name="username">
		<button type="submit">Login</button>
	</form>

	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION['user'] = $_POST['username'];
		header("Location: dashboard.php");
		exit();
	}
	?>
</body>

</html>