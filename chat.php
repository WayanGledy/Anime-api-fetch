<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$usersFile = 'users.json';
$chatFile = 'chat.json';

// Baca pengguna dan chat
$users = json_decode(file_get_contents($usersFile), true);
$chat = file_exists($chatFile) ? json_decode(file_get_contents($chatFile), true) : [];

// Proses pengiriman pesan atau gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message']) || isset($_FILES['image'])) {
        $message = isset($_POST['message']) ? $_POST['message'] : "";
        $image = "";

        if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
            // Simpan gambar yang dikirim
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image = $target_file;
        }

        // Tambahkan pesan atau gambar ke file chat
        $chat[] = [
            'username' => $_SESSION['username'],
            'message' => $message,
            'image' => $image,
            'profile_picture' => $users[$_SESSION['username']]['profile_picture'] ?? 'default_profile.png'
        ];

        file_put_contents($chatFile, json_encode($chat));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - <?= $_SESSION['username']; ?></title>
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

    <div class="chat-container">
        <h2>Group Chat</h2>
        <div class="chat-box">
            <?php foreach ($chat as $entry): ?>
                <div class="chat-message">
                    <img src="<?= $entry['profile_picture']; ?>" alt="Profile Picture" width="50" class="chat-profile">
                    <div class="chat-content">
                        <strong><?= $entry['username']; ?>:</strong><br>
                        <?php if ($entry['message']): ?>
                            <p><?= $entry['message']; ?></p>
                        <?php endif; ?>
                        <?php if ($entry['image']): ?>
                            <img src="<?= $entry['image']; ?>" alt="Image" width="200">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="chat.php" method="post" enctype="multipart/form-data">
            <input type="text" name="message" placeholder="Tulis pesan..." class="chat-input">
            <input type="file" name="image" class="chat-input-file">
            <button type="submit" class="chat-submit">Kirim</button>
        </form>
    </div>
</body>
</html>