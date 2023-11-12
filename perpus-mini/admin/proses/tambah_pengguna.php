<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../manajemen-pengguna.php?error=4"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Cek apakah username sudah ada dalam database
    $checkQuery = "SELECT username FROM pengguna WHERE username = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Username sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../manajemen-pengguna.php?error=2");
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Buat query SQL untuk menambahkan pengguna baru
    $query = "INSERT INTO pengguna (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar pengguna
        header("Location: ../manajemen-pengguna.php?success=1"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan pengguna, tampilkan pesan kesalahan
        header("Location: ../manajemen-pengguna.php?error=1");
        exit();
    }

}
?>
