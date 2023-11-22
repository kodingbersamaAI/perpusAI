<?php
require('../../server/sesi.php');
require('../../server/koneksi.php');

// Validasi token CSRF
if (!isset($_POST['csrf_token']) || !checkCSRFToken($_POST['csrf_token'])) {
    // Token CSRF tidak valid, lakukan tindakan yang sesuai
    header("Location: ../manajemen-transaksi.php?error=5");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_STRING);
    $jatuhTempoHari = filter_input(INPUT_POST, 'jatuhTempo', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Validasi data jika diperlukan

    // Cek ketersediaan buku berdasarkan judul
    // Query untuk mendapatkan jumlah total buku dengan judul yang diinput
    $queryTotalBuku = "SELECT jumlahBuku FROM buku WHERE judul = ?";
    $stmtTotalBuku = $conn->prepare($queryTotalBuku);
    $stmtTotalBuku->bind_param("s", $judul);
    $stmtTotalBuku->execute();
    $resultTotalBuku = $stmtTotalBuku->get_result();
    $rowTotalBuku = $resultTotalBuku->fetch_assoc();
    $jumlahTotalBuku = $rowTotalBuku['jumlahBuku'];

    // Query untuk mendapatkan jumlah buku yang sedang dipinjam berdasarkan judul
    $queryDipinjam = "SELECT COUNT(*) AS dipinjam FROM transaksi WHERE judul = ? AND status = 'Dipinjam'";
    $stmtDipinjam = $conn->prepare($queryDipinjam);
    $stmtDipinjam->bind_param("s", $judul);
    $stmtDipinjam->execute();
    $resultDipinjam = $stmtDipinjam->get_result();
    $rowDipinjam = $resultDipinjam->fetch_assoc();
    $jumlahDipinjam = $rowDipinjam['dipinjam'];

    // Hitung sisa buku yang tersedia
    $sisaBuku = $jumlahTotalBuku - $jumlahDipinjam;

    if ($sisaBuku > 0) {
        
    } else {
        // Buku tidak tersedia
        header("Location: ../manajemen-transaksi.php?error=4");
        exit();
    }

    // Cek apakah username sudah meminjam sebanyak 3 kali
    $borrowLimitQuery = "SELECT COUNT(*) as count FROM transaksi WHERE username = ? AND status = 'Dipinjam'";
    $stmtLimit = $conn->prepare($borrowLimitQuery);
    $stmtLimit->bind_param("s", $username);
    $stmtLimit->execute();
    $resultLimit = $stmtLimit->get_result();
    $rowLimit = $resultLimit->fetch_assoc();

    // Periksa jika pengguna sudah meminjam sebanyak 3 kali
    if ($rowLimit['count'] >= 3) {
        header("Location: ../manajemen-transaksi.php?error=2");
        exit();
    }

    // Hitung tanggal jatuh tempo berdasarkan tanggal sekarang + jumlah hari
    $jatuhTempo = date('Y-m-d', strtotime("+" . $jatuhTempoHari . " days"));

    // Lanjutkan dengan menambahkan transaksi
    $insertQuery = "INSERT INTO transaksi (username, judul, jatuhTempo, status) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("ssss", $username, $judul, $jatuhTempo, $status);

    if ($stmtInsert->execute()) {
        // Transaksi berhasil ditambahkan
        header("Location: ../manajemen-transaksi.php?success=1");
        exit();
    } else {
        // Gagal menambahkan transaksi, tampilkan pesan kesalahan
        header("Location: ../manajemen-transaksi.php?error=1");
        exit();
    }
}
?>