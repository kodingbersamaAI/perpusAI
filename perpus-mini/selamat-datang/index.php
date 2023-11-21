<?php 
include "../server/sesi.php"; 
include "../server/koneksi.php";

if (isset($_SESSION['username'])) {
    $dashboardLink = ''; // Inisialisasi variabel untuk link dashboard
    if ($_SESSION['role'] === 'admin') {
        $dashboardLink = '../../../admin/dashboard.php';
    } elseif ($_SESSION['role'] === 'user') {
        $dashboardLink = '../../../user/dashboard.php';
    }
  }

// Menghitung jumlah buku dalam koleksi
$queryBuku = "SELECT COUNT(*) AS totalBuku FROM buku";
$resultBuku = $conn->query($queryBuku);

if ($resultBuku) {
    $rowBuku = $resultBuku->fetch_assoc();
    $totalBuku = $rowBuku['totalBuku'];
} else {
    $totalBuku = 0;
}

// Menghitung jumlah anggota dari tabel pengguna dengan role anggota
$queryAnggota = "SELECT COUNT(*) AS totalAnggota FROM pengguna WHERE role = 'user'";
$resultAnggota = $conn->query($queryAnggota);

if ($resultAnggota) {
    $rowAnggota = $resultAnggota->fetch_assoc();
    $totalAnggota = $rowAnggota['totalAnggota'];
} else {
    $totalAnggota = 0;
}

// Menghitung jumlah peminjaman dengan status dipinjam
$queryPinjaman = "SELECT COUNT(*) AS totalPinjaman FROM transaksi WHERE status = 'Dipinjam'";
$resultPinjaman = $conn->query($queryPinjaman);

if ($resultPinjaman) {
    $rowPinjaman = $resultPinjaman->fetch_assoc();
    $totalPinjaman = $rowPinjaman['totalPinjaman'];
} else {
    $totalPinjaman = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Depan - PerpusAI</title>

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
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Koleksi Buku</span>
                <span class="info-box-number"><?php echo "$totalBuku"; ?> Buku</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Anggota Terdaftar</span>
                <span class="info-box-number"><?php echo "$totalAnggota"; ?> Anggota</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Transaksi Pinjaman</span>
                <span class="info-box-number"><?php echo "$totalPinjaman"; ?> Pinjaman</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr>
        <!-- Menu Seacrh -->
        <h2 class="text-center display-5">Kotak Pencarian</h2>
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <form onsubmit="submitForm(event)">
              <div class="input-group">
                <input type="search" class="form-control form-control-lg" id="judul" name="judul" placeholder="Tulis kata kunci di sini">            
                <div class="input-group-append">
                  <button type="submit" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div id="judulResult"></div>
            </form>
          </div>
        </div><hr><!-- /.Menu Seacrh -->
        <div class="row">
          <div class="col-12">
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
        </div>
        <!-- Modal Login -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalLogin">
          <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <strong>Login PerpusAI</strong>
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
    $(document).ready(function() {
      // Cek apakah parameter error=1 ada di URL
      var errorParam = new URLSearchParams(window.location.search).get('error');
      
      if (errorParam === '1') {
        Swal.fire({
          icon: 'error',
          title: 'Login Gagal',
          text: 'Silakan coba lagi.'
        });
      }

      if (errorParam === '2') {
        Swal.fire({
          icon: 'error',
          title: 'Ditolak',
          text: 'Anda tidak memiliki akses ke halaman.'
        });
      }
    });
</script>

<script>
$(document).ready(function() {
    $('#judul').on('input', function() {
        var input = $(this).val();

        if (input.length >= 1) {
            $.ajax({
                type: 'POST',
                url: 'proses/pencarian_judul.php',
                data: { input: input },
                success: function(response) {
                    $('#judulResult').html(response);
                }
            });
        } else {
            $('#judulResult').html('');
        }
    });

    // Tambahkan fungsi untuk menanggapi klik pada opsi pencarian
    $('#judulResult').on('click', '.judul-option', function() {
        var selectedJudul = $(this).text();
        $('#judul').val(selectedJudul);
        $('#judulResult').html('');
    });
});
</script>

<script>
  function submitForm(event) {
    event.preventDefault(); // Tambahkan ini untuk mencegah pengiriman formulir default
    const judulValue = document.getElementById('judul').value;
    const form = document.querySelector('form');
    form.action = `detail-buku.php?judul=${judulValue}`;
    form.submit(); // Mungkin perlu mengirimkan formulir secara manual setelah mengubah action
  }
</script>

<!-- /Script -->
</body>
</html>
