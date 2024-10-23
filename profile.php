<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$usersFile = 'users.json';
$users = json_decode(file_get_contents($usersFile), true);
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_picture'])) {
        // Simpan foto profil
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);

        // Simpan lokasi foto profil ke file JSON
        $users[$username]['profile_picture'] = $target_file;
        file_put_contents($usersFile, json_encode($users));
    }
}

$profile_picture = isset($users[$username]['profile_picture']) ? $users[$username]['profile_picture'] : 'default_profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?= $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="chat.php">Chat</a>
        <div class="dropdown">
            <button class="dropbtn">☰</button>
            <div class="dropdown-content">
                <a href="chat.php">Chat</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <h2>Profile <?= $_SESSION['username']; ?></h2>

    <img src="<?= $profile_picture; ?>" alt="Profile Picture" width="150"><br><br>

    <form action="profile.php" method="post" enctype="multipart/form-data">
        <label for="profile_picture">Upload Foto Profil:</label>
        <input type="file" name="profile_picture" id="profile_picture"><br><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>