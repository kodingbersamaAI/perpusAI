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
          <div class="col-md-8 offset-md-2">
            <form onsubmit="submitForm(event)">
              <div class="input-group">
                <input type="search" class="form-control" id="judul" name="judul" placeholder="Tulis kata kunci di sini">            
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                      <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div id="judulResult"></div>
            </form>
          </div>
        </div><hr>
        <h4 class="text-center">Detail Buku</h4><br>
        <div class="row">
          <div class="col-md-3 col-12">
            <div class="card">
              <div class="card-body text-center">
                <?php
                if (isset($_GET['judul'])) {
                  $judul = $_GET['judul'];
                  // Query SQL untuk mendapatkan cover buku sesuai judul
                  $query = "SELECT cover FROM buku WHERE judul = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->bind_param("s", $judul);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $cover = $row['cover'];
                    // Tampilkan gambar cover
                    echo "<img src='$cover' alt='Cover Buku' style='max-width: 250px;' />";
                  } else {
                    echo "Gambar tidak ditemukan untuk judul tersebut.";
                  }
                } else {
                  echo "Judul buku tidak ditemukan di URL.";
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-9 col-12">
            <div class="card flex-column">
              <div class="card-body">
                <?php
                if (isset($_GET['judul'])) {
                  $judul = $_GET['judul'];
                  // Query SQL untuk mendapatkan data buku sesuai judul
                  $query = "SELECT * FROM buku WHERE judul = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->bind_param("s", $judul);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Tampilkan data
                    echo "<h5>" . $row['judul'] . "</h5>";
                    echo "<p>" . $row['tahun'] . "</p><hr>";
                    echo "<p><b>Penerbit :</b> " . $row['penerbit'] . "</p>";
                    echo "<p><b>Pengarang :</b> " . $row['pengarang'] . "</p>";
                    echo "<p><b>Nomor Seri :</b> " . $row['seri'] . "</p>";
                    echo "<p><b>Nomor ISBN :</b> " . $row['isbn'] . "</p>";
                    echo "<p><b>Jumlah Koleksi Buku :</b> " . $row['jumlahBuku'] . "</p>";
                  } else {
                    echo "Tidak ditemukan data untuk judul tersebut.";
                  }
                } else {
                  echo "Judul buku tidak ditemukan di URL.";
                }
                ?>
              </div>
            </div>
            <div class="card flex-column mt-3">
              <div class="card-body">
                <?php
                if (isset($_GET['judul'])) {
                    $judul = $_GET['judul'];

                    // Query SQL untuk menghitung jumlah transaksi berdasarkan judul buku
                    $query = "SELECT COUNT(*) AS jumlahPinjam FROM transaksi WHERE judul = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $judul);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $jumlahPinjam = $row['jumlahPinjam'];
                        echo 'Telah dipinjam sebanyak: <b>' . $jumlahPinjam . '</b> kali';
                    } else {
                        echo 'Tidak ada data transaksi untuk judul ini.';
                    }
                }
                ?><br>
                <?php
                if (isset($_GET['judul'])) {
                    $judul = $_GET['judul'];

                    // Query SQL untuk menghitung jumlah transaksi berdasarkan judul buku
                    $query = "SELECT COUNT(*) AS jumlahPinjamAktif FROM transaksi WHERE judul = ? AND status = 'Dipinjam'";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $judul);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $jumlahPinjamAktif = $row['jumlahPinjamAktif'];
                        echo 'Pinjaman aktif saat ini: <b>' . $jumlahPinjamAktif . '</b> pinjaman';
                    } else {
                        echo 'Tidak ada data transaksi untuk judul ini.';
                    }
                }
                ?>
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
