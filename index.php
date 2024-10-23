<?php
session_start();

// Periksa jika user sudah login
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

// Baca file JSON pengguna
$usersFile = 'users.json';
$users = [];
if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true);
}

// Proses pendaftaran dan login
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($_POST['register'])) {
        // Proses Pendaftaran
        if (!isset($users[$username])) {
            // Tambahkan user baru ke file JSON
            $users[$username] = ['password' => password_hash($password, PASSWORD_DEFAULT), 'role' => 'user'];
            file_put_contents($usersFile, json_encode($users));
            $error = "Pendaftaran berhasil, silakan login!";
        } else {
            $error = "Username sudah digunakan, silakan gunakan username lain.";
        }
    } elseif (isset($_POST['login'])) {
        // Proses Login
        if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
            // Set sesi pengguna
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $users[$username]['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Daftar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login atau Daftar</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= $error; ?></p>
        <?php endif; ?>

        <form action="index.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Masukkan username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Masukkan password" required><br><br>

            <button type="submit" name="login">Login</button>
            <button type="submit" name="register">Daftar</button>
        </form>
    </div>
</body>
</html>