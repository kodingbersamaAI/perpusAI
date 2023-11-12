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
  <title>Transaksi - PerpusAI</title>

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
        
        <?php include "menu.php" ?>

        <!-- Data Transaksi -->
        <div class="row">
          <div class="col-md-8 col-12">
            <div class="card">
              <div class="card-header">
                Data Transaksi
              </div>
              <div class="card-body">
                <table id="transaksiTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Peminjam</th>
                      <th>Buku</th>
                      <th>Batas Peminjaman</th>
                      <th>Denda</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Query SQL untuk mengambil data transaksi
                  $queryTransaksi = "SELECT * FROM transaksi WHERE status = 'Dipinjam' ORDER BY jatuhTempo ASC";
                  $resultTransaksi = $conn->query($queryTransaksi);

                  if ($resultTransaksi->num_rows > 0) {
                    while ($row = $resultTransaksi->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["username"] . "</td>";
                      echo "<td>";
                      // Tombol Detail dengan Modal
                      echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalJudul" . $row["id"] . "' alt='Judul Buku Pinjaman'><i class='fas fa-eye'></i></button>&nbsp";
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
                      echo '<td>Rp. ' . $totalDenda . '</td>';

                      echo "<td>" . $row["status"] . "</td>";
                      echo "<td>";
                      // Tombol Edit dengan Modal
                      echo "<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modalUpdate" . $row["id"] . "' alt='Edit Data Transaksi'><i class='fas fa-history'></i></button>&nbsp;";
                      // Tombol Hapus dengan Modal
                      echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalHapus" . $row["id"] . "' alt='Hapus Data Transaksi'><i class='fas fa-trash'></i></button>&nbsp;";
                      echo "</td>";
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
                      // Modal untuk Memperbarui Status Data Transaksi
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalUpdate" . $row["id"] . "'>
                              <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <div class='modal-title'>Perbarui Data Transaksi</div>
                                  </div>
                                  <div class='modal-body'>
                                    <form action='proses/update_transaksi.php' method='POST'>
                                    <div class='form-group'>
                                      <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                                      <p>Anda akan mengembalikan transaksi dari <b>" . $row["username"] . "</b> untuk buku <b>" . $row["judul"] . "</b> dengan denda sebesar <b>Rp. " . $totalDenda . "</b></p>
                                      <input type='hidden' class='form-control' id='id' name='id' value='" . $row["id"] . "'>
                                      <input type='hidden' class='form-control' id='status' name='status' value='Dikembalikan'>
                                      <input type='hidden' class='form-control' id='denda' name='denda' value='" . $totalDenda . "'>
                                    </div>
                                      <button type='submit' class='btn btn-success btn-sm'>Kembalikan Buku</button>
                                      <button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'>Batal</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>";
                      // Modal untuk Hapus Data Transaksi
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalHapus" . $row["id"] . "'>
                              <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <div class='modal-title'>Hapus Data Transaksi</div>
                                  </div>
                                  <div class='modal-body'>
                                    <form action='proses/hapus_transaksi.php' method='POST'>
                                      <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                                      <input type='hidden' class='form-control' id='id' name='id' value='" . $row["id"] . "'>
                                      <p>Apakah Anda yakin akan menghapus data transaksi dari <b>" . $row["username"] . "</b> yang meminjam buku <b>" . $row["judul"] . "</b></p>
                                      <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                                      <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Batal</button>
                                    </form>
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
          </div><!-- /.Data Transaksi -->
          <!-- Tambah Data Transaksi -->
          <div class="col-md-4 col-12">
            <div class="card">
              <div class="card-header">
                Tambah Data Transaksi
              </div>
              <div class="card-body">
                <form action="proses/tambah_transaksi.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username">
                    <div id="usernameResult"></div>
                  </div>
                  <div class="form-group">
                    <label for="judul">Judul Buku:</label>
                    <input type="text" class="form-control" id="judul" name="judul">
                    <div id="judulResult"></div>
                  </div>
                  <div class="form-group">
                    <label for="jatuhTempo">Masa Peminjaman:</label>
                    <input type="number" class="form-control" id="jatuhTempo" name="jatuhTempo" placeholder="Berapa hari dipinjam, isi dengan angka">
                  </div>
                  <input type="hidden" class="form-control" id="status" name="status" value="Dipinjam">
                  <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
                </form>
              </div>
            </div>
          </div><!-- /. Tambah Data Transaksi -->
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
    // Cek apakah parameter success=1 ada di URL
    var successParam = new URLSearchParams(window.location.search).get('success');
    var errorParam = new URLSearchParams(window.location.search).get('error');
    
    if (successParam === '1') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambahkan data transaksi.'
      });
    }

    if (successParam === '2') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Buku berhasil dikembalikan'
      });
    }

    if (successParam === '3') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data transaksi berhasil dihapus'
      });
    }

    if (errorParam === '1') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menambahkan data transaksi.'
      });
    }

    if (errorParam === '2') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Pengguna telah meminjam lebih dari 3 buku.'
      });
    }

    if (errorParam === '3') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Buku gagal dikembalikan.'
      });
    }

    if (errorParam === '4') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Sisa buku tidak ada.'
      });
    }

    if (errorParam === '5') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Tindakan tidak diizinkan.'
      });
    }
  });
</script>
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
    $('#username').on('input', function() {
        var input = $(this).val();

        if (input.length >= 1) {
            $.ajax({
                type: 'POST',
                url: 'proses/pencarian_username.php',
                data: { input: input },
                success: function(response) {
                    $('#usernameResult').html(response);
                }
            });
        } else {
            $('#usernameResult').html('');
        }
    });

    // Tambahkan fungsi untuk menanggapi klik pada opsi pencarian
    $('#usernameResult').on('click', '.username-option', function() {
        var selectedUsername = $(this).text();
        $('#username').val(selectedUsername);
        $('#usernameResult').html('');
    });
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

<!-- /Script -->
</body>
</html>