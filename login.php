<?php
include 'includes/session.php';
// Redirect if already logged in
if (isset($_SESSION['user'])) {
	header("Location: dashboard.php");
	exit();
}

$error = "";
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