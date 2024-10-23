<?php
session_start();

$usersFile = 'users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!file_exists($usersFile)) {
        file_put_contents($usersFile, json_encode([]));
    }

    $users = json_decode(file_get_contents($usersFile), true);

    if ($action == 'register') {
        // Proses pendaftaran
        if (!isset($users[$username])) {
            $users[$username] = ['password' => password_hash($password, PASSWORD_DEFAULT), 'role' => 'user'];
            file_put_contents($usersFile, json_encode($users));
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: dashboard.php"); // Redirect ke dashboard user
            exit;
        } else {
            echo "Username sudah ada!";
        }
    } elseif ($action == 'login') {
        // Proses login
        if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $users[$username]['role'];
            header("Location: dashboard.php"); // Redirect ke dashboard
            exit;
        } else {
            echo "Login gagal!";
        }
    }
}
?>