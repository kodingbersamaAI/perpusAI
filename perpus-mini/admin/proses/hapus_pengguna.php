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

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan pengguna baru
    $query = "DELETE FROM pengguna WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar pengguna
        header("Location: ../manajemen-pengguna.php?success=2"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan pengguna, tampilkan pesan kesalahan
        header("Location: ../manajemen-pengguna.php?error=3");
        exit();
    }

}
?>
