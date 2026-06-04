<?php
session_start();
// Tarik file koneksi database
require_once '../config/database.php';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Ambil data user berdasarkan username menggunakan Prepared Statement
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        // Memverifikasi password dengan password_verify
        if (password_verify($password, $user['password'])) {
            
            // Set session login admin
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $user['id'];
            $_SESSION['admin_username']  = $user['username'];

            // Alihkan ke halaman transisi puitis (login-loading.php)
            header("Location: login-loading.php");
            exit;
        }
    }

    // Jika gagal, kembalikan ke login
    header("Location: login.php?pesan=gagal");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>