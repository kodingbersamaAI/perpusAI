<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";
include "akses.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - PerpusAI</title>

  <?php include "../universal/head.php" ?>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <?php include "navbar.php" ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Tata Tertib PerpusAI
              </div>
              <div class="card-body">
                <h5><b>Peraturan Umum</b></h5>
                <ol>
                  <li>Berpakaian sopan dan tidak diperkenankan memakai kaos oblong, jaket, dan sandal.</li>
                  <li>Mengisi daftar pengunjung yang sudah disediakan.</li>
                  <li>Tidak diperkenankan membawa buku, tas, map, dan sejenisnya, serta membawa jaket ke ruang perpustakaan.</li>
                  <li>Tidak diperkenankan menyimpan uang, perhiasan, dan barang-barang berharga lainnya dalam perlengkapan barang yang dititipkan.</li>
                  <li>Menjaga kerapihan bahan pustaka, kebersihan, keamanan, dan ketenangan belajar.</li>
                  <li>Tidak diperkenankan membawa makanan dan minuman atau pun makan-makanan dan merokok di ruang perpustakaan.</li>
                  <li>Memperlihatkan kepada petugas barang/buku yang dibawa pada saat masuk dan keluar perpustakaan.</li>
                </ol>
                <h5><b>Peraturan Peminjaman Buku</b></h5>
                <ol>
                  <li><b>Prosedur Peminjaman</b></li>
                    <ul>
                      <li>Setiap Peminjam harus memperlihatkan kartu anggota perpustakaan yang masih berlaku.</li>
                      <li>Setiap Peminjam tidak diperkenankan menggunakan kartu anggota perpustakaan milik orang lain.</li>
                      <li>Peminjaman buku perorang maksimal 3 buku.</li>
                      <li>Buku-buku yang dipinjam paling lambat dikembalikan 7 (tujuh) hari terhitung mulai tanggal peminjaman.</li>
                      <li>Buku yang telah habis masa pinjamannya harus dikembalikan tepat waktunya dan dapat diperpanjang waktu pinjamnya.</li>
                    </ul><br>
                  <li><b>Kewajiban dan Tanggung Jawab Peminjam</b></li>
                    <ul>
                      <li>Peminjam diwajibkan memelihara buku yang dipinjamnya dengan baik dan dilarang membuat tulisan, coretan atau merusak/merobek halaman buku.</li>
                      <li>Kerusakan buku yang dipinjam yang disebabkan oleh peminjam, sepenuhnya menjadi tanggung jawab peminjam dan diharuskan mengganti dengan buku yang sama dalam keadaan utuh dan ditambah dengan denda keterlambatan.</li>
                      <li>Kehilangan buku perpustakaan yang sedang dipinjam sepenuhnya menjadi tanggung jawab peminjam. Penggantian dapat berupa:</li>
                      <ul>
                        <li>Buku yang sama judulnya;</li>
                        <li>Uang yang besarnya:<br>1 X harga buku, untuk buku-buku terbitan dalam negeri, ditambah biaya administrasi, atau 2 X lipat harga buku, untuk buku-buku terbitan dalam negeri yang termasuk kategori buku langka, atau 3 X harga buku, untuk buku-buku terbitan luar negeri.</li>
                      </ul>
                    </ul><br>
                  <li><b>Sanksi</b></li>
                    <ul>
                      <li>Setiap peminjam yang mempunyai buku pinjaman dan telah melewati batas waktu peminjamannya tidak diperkenankan meminjam buku lain sebelum buku tersebut dikembalikan.</li>
                      <li>Setiap peminjaman yang terlambat mengembalikan buku dikenakan denda sesuai dengan ketentuan yang berlaku.</li>
                      <li>Setiap peminjam yang terlambat mengembalikan buku pinjamannya sampai 2(dua) bulan berturut-turut terhitung sejak jatuh tempo tanggal pengembaliannya, dinyatakan menghilangkan buku tersebut.</li>
                    </ul>
                </ol>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card">
              <div class="card-header">
                Daftar Pinjaman
              </div>
              <div class="card-body">
                <table id="transaksiTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Buku</th>
                      <th>Batas Peminjaman</th>
                      <th>Denda</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  $usernameSesi = $_SESSION['username']; // Ambil username dari sesi

                  // Query SQL untuk mengambil data transaksi
                  $queryTransaksi = "SELECT * FROM transaksi WHERE username = '$usernameSesi' ORDER BY status ASC";
                  $resultTransaksi = $conn->query($queryTransaksi);

                  if ($resultTransaksi->num_rows > 0) {
                    while ($row = $resultTransaksi->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>";
                      // Tombol Detail dengan Modal
                      echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalJudul" . $row["id"] . "' alt='Judul Buku Pinjaman'></i>Lihat Judul Buku</button>&nbsp";
                      echo "</td>";
                      echo '<td>' . date('d F Y', strtotime($row['jatuhTempo'])) . '</td>';
                      // Mendapatkan tanggal sekarang
                      $tanggalSekarang = time();
                      // Menghitung selisih hari
                      $selisihHari = floor(($tanggalSekarang - strtotime($row['jatuhTempo'])) / (60 * 60 * 24));
                      // Menentukan nilai denda per hari
                      $dendaPerHari = 1000; // Ganti dengan nilai denda per hari yang sesuai
                      // Menghitung total denda
                      $totalDenda = max(0, $selisihHari * $dendaPerHari); // Ganti max(0, ...) untuk menghindari nilai negatif
                      // Menampilkan dalam tag <td>
                      echo '<td>' . $totalDenda . '</td>';
                      echo "<td>" . $row["status"] . "</td>";
                      echo "</tr>";
                      // Modal untuk Detail Data Transaksi
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalJudul" . $row["id"] . "'>
                              <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                  <div class='modal-body'>
                                    " . $row["judul"] . "
                                  </div>
                                </div>
                              </div>
                            </div>";
                    }
                  } else {
                      echo '<tr><td colspan="6">Tidak ada data transaksi.</td></tr>';
                  }
                  $conn->close();
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Footer -->

  <?php include "../universal/footer.php" ?>

  <!-- /Footer -->

</div>
<!-- ./wrapper -->

<!-- Script -->

<?php include "../universal/script.php" ?>

<script>
  $(function () {
    $("#transaksiTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>