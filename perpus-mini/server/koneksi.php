<?php
// Konfigurasi database
$host = "localhost";
$database = "perpusAI";
$username = "root";
$password = "";

// Buat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set karakter set koneksi ke UTF-8
if (!$conn->set_charset("utf8")) {
    die("Gagal mengatur karakter set ke UTF-8: " . $conn->error);
}

// Matikan error reporting pada produksi
error_reporting(0);

// Fungsi untuk membersihkan input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}
?>
