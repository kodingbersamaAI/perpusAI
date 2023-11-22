<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, tindakan apa yang perlu diambil? Redirect atau tindakan lainnya.
    // Misalnya:
    header("Location: ../manajemen-transaksi.php?error=5.php"); // Ganti dengan halaman yang sesuai
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $denda_transaksi = filter_input(INPUT_POST, 'denda', FILTER_SANITIZE_STRING);
    $status_transaksi = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Jalankan tindakan perbarui transaksi
    $query = "UPDATE transaksi SET denda = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $denda_transaksi, $status_transaksi, $id_transaksi);

    if ($stmt->execute()) {
        // Transaksi berhasil diperbarui
        header("Location: ../manajemen-transaksi.php?success=2"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        // Gagal memperbarui transaksi
        header("Location: ../manajemen-transaksi.php?error=3"); // Ganti dengan halaman yang sesuai
        exit();
    }
}
?>
