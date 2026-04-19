<?php
include 'includes/session.php';

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

$error   = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS)));
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));
    $confirm  = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_DEFAULT));

    // Validation
    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (strlen($username) < 3 || strlen($username) > 20) {
        $error = "Username must be between 3 and 20 characters.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = "Username may only contain letters, numbers, and underscores.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Ensure data directory exists
        if (!is_dir('data')) {
            mkdir('data', 0755, true);
        }

        $users_file    = 'data/users.txt';
        $username_taken = false;

        // Check if username already exists
        if (file_exists($users_file)) {
            $lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $parts = explode('|', $line);
                if (trim($parts[0]) === $username) {
                    $username_taken = true;
                    break;
                }
            }
        }

        if ($username_taken) {
            $error = "That username is already taken. Please choose another.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents($users_file, $username . '|' . $hashed . PHP_EOL, FILE_APPEND | LOCK_EX);
            $success = "Account created! You can now sign in.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy! — Create Account</title>
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
                <h1>New Contestant</h1>
                <p>Create your account to start playing</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">!</span>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>
                    <?php echo $success; ?>
                    <a href="login.php" class="alert-link">Sign in now →</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" class="auth-form" novalidate>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input"
                        value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                        placeholder="Choose a username (3–20 chars)"
                        autocomplete="username"
                        required>
                    <span class="form-hint">Letters, numbers, and underscores only</span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="At least 6 characters"
                        autocomplete="new-password"
                        required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="form-input"
                        placeholder="Repeat your password"
                        autocomplete="new-password"
                        required>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    Create Account
                    <span class="btn-arrow">→</span>
                </button>

            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php" class="auth-link">Sign in</a></p>
            </div>
        </div>

        <div class="dollar-strip">
            <span>$200</span><span>$400</span><span>$600</span><span>$800</span><span>$1000</span>
        </div>

    </div>

</body>

</html>