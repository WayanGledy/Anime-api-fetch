<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.html");
    exit;
}

$usersFile = 'users.json';
$users = json_decode(file_get_contents($usersFile), true);

if (isset($_POST['delete_user'])) {
    $userToDelete = $_POST['delete_user'];
    if (isset($users[$userToDelete])) {
        unset($users[$userToDelete]);
        file_put_contents($usersFile, json_encode($users));
    }
}

if (isset($_POST['ban_user'])) {
    $userToBan = $_POST['ban_user'];
    if (isset($users[$userToBan])) {
        $users[$userToBan]['banned'] = true;
        file_put_contents($usersFile, json_encode($users));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?= $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="chat.php">Chat</a>
        <a href="admin.php">Administrator</a>
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

    <h2>Admin Panel</h2>

    <h3>Total Pengguna: <?= count($users); ?></h3>

    <table border="1">
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $username => $user): ?>
        <tr>
            <td><?= $username; ?></td>
            <td><?= $user['role']; ?></td>
            <td>
                <form action="admin.php" method="post" style="display:inline;">
                    <input type="hidden" name="delete_user" value="<?= $username; ?>">
                    <button type="submit">Delete</button>
                </form>
                <?php if (!isset($user['banned'])): ?>
                <form action="admin.php" method="post" style="display:inline;">
                    <input type="hidden" name="ban_user" value="<?= $username; ?>">
                    <button type="submit">Ban</button>
                </form>
                <?php else: ?>
                    <span>Banned</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>