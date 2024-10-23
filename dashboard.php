<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="chat.php">Chat</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin.php">Administrator</a>
        <?php endif; ?>
        <div class="dropdown">
            <button class="dropbtn">☰</button>
            <div class="dropdown-content">
                <a href="chat.php">Chat</a>
                <a href="profile.php">Profile</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <h2>Welcome, <?= $_SESSION['username']; ?>!</h2>
    <p>Ini adalah dashboard Anda. Akses menu di atas untuk berpindah halaman.</p>
</body>
</html>