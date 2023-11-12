<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../manajemen-transaksi.php?error=5"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan transaksi baru
    $query = "DELETE FROM transaksi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar transaksi
        header("Location: ../manajemen-transaksi.php?success=3"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan transaksi, tampilkan pesan kesalahan
        header("Location: ../manajemen-transaksi.php?error=3");
        exit();
    }

}
?>
