<?php

// Periksa peran pengguna dari sesi
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Tentukan peran yang diizinkan untuk mengakses folder ini
$allowedRoles = ['admin']; // Ganti dengan peran yang sesuai

if (!in_array($userRole, $allowedRoles)) {
    // Pengguna tidak memiliki peran yang sesuai, arahkan ke halaman yang sesuai
    header("Location: ../selamat-datang/index.php?error=2"); // Ganti dengan halaman yang sesuai untuk akses yang tidak sah
    exit();
}

?>