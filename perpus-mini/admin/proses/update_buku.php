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
    $id_buku = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $cover = filter_input(INPUT_POST, 'cover', FILTER_SANITIZE_STRING);
    $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_STRING);
    $penerbit = filter_input(INPUT_POST, 'penerbit', FILTER_SANITIZE_STRING);
    $pengarang = filter_input(INPUT_POST, 'pengarang', FILTER_SANITIZE_STRING);
    $tahun = filter_input(INPUT_POST, 'tahun', FILTER_SANITIZE_NUMBER_INT);
    $seri = filter_input(INPUT_POST, 'seri', FILTER_SANITIZE_STRING);
    $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_STRING);
    $jumlahBuku = filter_input(INPUT_POST, 'jumlahBuku', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Jalankan tindakan perbarui buku
    $query = "UPDATE buku SET cover = ?, judul = ?, penerbit = ?, pengarang = ?, tahun = ?, seri = ?, isbn = ?, jumlahBuku = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssissss", $cover, $judul, $penerbit, $pengarang, $tahun, $seri, $isbn, $jumlahBuku, $id_buku);

    if ($stmt->execute()) {
        // Buku berhasil diperbarui
        header("Location: ../manajemen-buku.php?success=3"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal memperbarui buku
        header("Location: ../manajemen-buku.php?error=4"); // Ganti dengan halaman yang sesuai
        exit();
    }
}
?>
