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

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Jeopardy! — Sign In</title>
	<link rel="stylesheet" href="css/styles.css">
</head>

<body class="auth-body">
	<div class="auth-bg">
		<div class="bg-grid"></div>
		<div class="bg-glow"></div>
	</div>

	<div class="auth-wrapper">

		<div class="auth-logo">
			<div class="logo-mark">J!</div>
			<p class="logo-sub">JEOPARDY</p>
		</div>

		<div class="auth-card">
			<div class="auth-card-header">
				<h1>Welcome Back</h1>
				<p>Sign in to continue your streak</p>
			</div>

			<?php if (!empty($error)): ?>
				<div class="alert alert-error">
					<span class="alert-icon">!</span>
					<?php echo $error; ?>
				</div>
			<?php endif; ?>

			<form method="POST" action="login.php" class="auth-form" novalidate>

				<div class="form-group">
					<label for="username">Username</label>
					<input
						type="text"
						id="username"
						name="username"
						class="form-input"
						value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
						placeholder="Enter your username"
						autocomplete="username"
						required>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input
						type="password"
						id="password"
						name="password"
						class="form-input"
						placeholder="Enter your password"
						autocomplete="current-password"
						required>
				</div>

				<button type="submit" class="btn btn-primary btn-full">
					Sign In
					<span class="btn-arrow">→</span>
				</button>

			</form>

			<div class="auth-footer">
				<p>New player? <a href="register.php" class="auth-link">Create an account</a></p>
			</div>
		</div>

		<div class="dollar-strip">
			<span>$200</span><span>$400</span><span>$600</span><span>$800</span><span>$1000</span>
		</div>

	</div>

</body>

</html>