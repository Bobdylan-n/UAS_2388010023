<?php
// admin/auth-middleware.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah session login admin sudah diset atau belum
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Jika tidak ada session, paksa tendang ke halaman login dengan pesan peringatan
    header("Location: login.php?pesan=tamu");
    exit;
}
?>