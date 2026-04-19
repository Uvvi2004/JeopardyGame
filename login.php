<?php
include 'includes/session.php';
// Redirect if already logged in
if (isset($_SESSION['user'])) {
	header("Location: dashboard.php");
	exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim(htmlspecialchars(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS)));
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));

	if (empty($username) || empty($password)) {
		$error = "Please enter both username and password.";
	} else {
		$users_file = 'data/users.txt';
		$logged_in = false;

		if (file_exists($users_file)) {
			$lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			foreach ($lines as $line) {
				$parts = explode('|', $line);
				if (count($parts) === 2) {
					$stored_user = trim($parts[0]);
					$stored_pass = trim($parts[1]);
					if ($stored_user === $username && password_verify($password, $stored_pass)) {
						$_SESSION['user'] = $username;
						$_SESSION['score'] = 0;
						$_SESSION['question_index'] = 0;
						$logged_in = true;
						break;
					}
				}
			}
		}

		if ($logged_in) {
			header("Location: dashboard.php");
			exit();
		} else {
			$error = "Invalid username or password.";
		}
	}
}
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