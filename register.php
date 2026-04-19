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
