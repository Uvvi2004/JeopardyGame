<?php
include 'includes/session.php';
check_login();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy! — Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="dash-body">

    <div class="auth-bg">
        <div class="bg-grid"></div>
        <div class="bg-glow"></div>
    </div>

    <div class="dash-wrapper">

        <!-- Header Bar -->
        <header class="dash-header">
            <div class="dash-logo">
                <span class="logo-mark-sm">J!</span>
                <span class="logo-sub-sm">JEOPARDY</span>
            </div>
            <div class="dash-user">
                <span class="user-label">Contestant</span>
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
            </div>
            <a href="logout.php" class="btn btn-ghost btn-sm">Sign Out</a>
        </header>

        <!-- Hero -->
        <section class="dash-hero">
            <p class="dash-greeting">Ready to play,</p>
            <h1 class="dash-name"><?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
            <p class="dash-tagline">Test your knowledge across categories and climb the leaderboard.</p>
        </section>

        <!-- Action Cards -->
        <div class="dash-cards">

            <div class="dash-card dash-card--primary">
                <div class="dash-card-icon">▶</div>
                <div class="dash-card-body">
                    <h2>Play Now</h2>
                    <p>Start a new game and answer questions to earn points.</p>
                </div>
                <a href="game.php" class="btn btn-primary">Start Game <span class="btn-arrow">→</span></a>
            </div>

            <div class="dash-card">
                <div class="dash-card-icon">🏆</div>
                <div class="dash-card-body">
                    <h2>Leaderboard</h2>
                    <p>See the top scores and where you rank among all contestants.</p>
                </div>
                <a href="leaderboard.php" class="btn btn-outline">View Scores <span class="btn-arrow">→</span></a>
            </div>

        </div>

        <!-- Stats Bar -->
        <div class="dash-stats">
            <div class="stat-item">
                <span class="stat-value">$<?php echo number_format($_SESSION['score'] ?? 0); ?></span>
                <span class="stat-label">Current Score</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-value"><?php echo $_SESSION['question_index'] ?? 0; ?></span>
                <span class="stat-label">Questions Answered</span>
            </div>
        </div>

    </div>

</body>

</html>