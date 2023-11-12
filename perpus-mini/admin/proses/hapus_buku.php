<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../manajemen-buku.php?error=5"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan


    // Buat query SQL untuk menambahkan buku baru
    $query = "DELETE FROM buku WHERE judul = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $judul);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar buku
        header("Location: ../manajemen-buku.php?success=2"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan buku, tampilkan pesan kesalahan
        header("Location: ../manajemen-buku.php?error=3");
        exit();
    }

}
?>
