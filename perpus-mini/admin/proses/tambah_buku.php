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
    $cover = filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_STRING);
    $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_STRING);
    $penerbit = filter_input(INPUT_POST, 'penerbit', FILTER_SANITIZE_STRING);
    $pengarang = filter_input(INPUT_POST, 'pengarang', FILTER_SANITIZE_STRING);
    $tahun = filter_input(INPUT_POST, 'tahun', FILTER_SANITIZE_STRING);
    $seri = filter_input(INPUT_POST, 'seri', FILTER_SANITIZE_STRING);
    $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_STRING);
    $jumlahBuku = filter_input(INPUT_POST, 'jumlahBuku', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Cek apakah judul sudah ada dalam database
    $checkQuery = "SELECT judul FROM buku WHERE judul = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $judul);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Username sudah ada, arahkan dengan pesan kesalahan
        header("Location: ../manajemen-buku.php?error=2");
        exit();
    }

    // Buat query SQL untuk menambahkan buku baru
    $query = "INSERT INTO buku (cover, judul, penerbit, pengarang, tahun, seri, isbn, jumlahBuku) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $cover, $judul, $penerbit, $pengarang, $tahun, $seri, $isbn, $jumlahBuku);

    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, arahkan ke halaman sukses atau daftar buku
        header("Location: ../manajemen-buku.php?success=1"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal menambahkan buku, tampilkan pesan kesalahan
        header("Location: ../manajemen-buku.php?error=1");
        exit();
    }

}
?>
