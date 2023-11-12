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
  <title>Buku - PerpusAI</title>

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

        <!-- Data Buku -->
        <div class="row">
          <div class="col-md-8 col-12">
            <div class="card">
              <div class="card-header">
                Data Buku
              </div>
              <div class="card-body">
                <table id="bukuTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Judul</th>
                      <th>Tahun</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Query SQL untuk mengambil data buku
                  $queryBuku = "SELECT * FROM buku ORDER BY judul ASC";
                  $resultBuku = $conn->query($queryBuku);

                  if ($resultBuku->num_rows > 0) {
                    while ($row = $resultBuku->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["judul"] . "</td>";
                      echo "<td>" . $row["tahun"] . "</td>";
                      echo "<td>";
                      // Tombol Detail dengan Modal
                      echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalDetail" . $row["id"] . "' alt='Detail Data Buku'><i class='fas fa-eye'></i></button>&nbsp";
                      // Tombol Edit dengan Modal
                      echo "<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modalEdit" . $row["id"] . "' alt='Edit Data Buku'><i class='fas fa-edit'></i></button>&nbsp;";
                      // Tombol Hapus dengan Modal
                      echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalHapus" . $row["id"] . "' alt='Hapus Data Buku'><i class='fas fa-trash'></i></button>&nbsp;";
                      echo "</td>";
                      echo "</tr>";
                      // Modal untuk Detail Data Buku
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDetail" . $row["id"] . "'>
                              <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <div class='modal-title'>Detail Data Buku</div>
                                  </div>
                                  <div class='modal-body'>
                                    <div class='container-fluid'>
                                      <div class='row'>
                                        <!-- Cover di bagian kiri -->
                                        <div class='col-md-4 mx-auto text-center'>
                                            <img src='" . $row["cover"] . "' style='max-width: 240px; padding-bottom: 15px;' class='img-fluid' alt='Cover Image'>
                                        </div>
                                        <br>
                                        <!-- Data-data lain di sebelah kanan -->
                                        <div class='col-md-8'>
                                          <!-- Tempatkan data-data lain di sini -->
                                          <h5>" . $row["judul"] . "</h5>
                                          <p>" . $row["tahun"] . "</p>
                                          <hr>
                                          <p><b>Penerbit:</b> " . $row["penerbit"] . "</p>
                                          <p><b>Pengarang:</b> " . $row["pengarang"] . "</p>
                                          <p><b>Nomor Seri:</b> " . $row["seri"] . "</p>
                                          <p><b>Nomor ISBN:</b> " . $row["isbn"] . "</p>
                                          <p><b>Jumlah Koleksi Buku:</b> " . $row["jumlahBuku"] . "</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger btn-sm'  data-dismiss='modal'>Tutup</button>
                                  </div>
                                </div>
                              </div>
                            </div>";
                      // Modal untuk Edit Data Buku
                        echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalEdit" . $row["id"] . "'>
                                <div class='modal-dialog modal-dialog-centered'>
                                  <div class='modal-content'>
                                    <div class='modal-header'>
                                      <div class='modal-title'>Edit Data Buku</div>
                                    </div>
                                    <div class='modal-body'>
                                      <form action='proses/update_buku.php' method='POST'>
                                        <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                                        <input type='hidden' class='form-control' id='id' name='id' value='" . $row["id"] . "' readonly>
                                        <div class='form-group'>
                                          <label for='cover'>Cover:</label>
                                          <input type='text' class='form-control' id='cover' name='cover' value='" . $row["cover"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='judul'>Judul:</label>
                                          <input type='text' class='form-control' id='judul' name='judul' value='" . $row["judul"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='penerbit'>Penerbit:</label>
                                          <input type='text' class='form-control' id='penerbit' name='penerbit' value='" . $row["penerbit"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='pengarang'>Pengarang:</label>
                                          <input type='text' class='form-control' id='pengarang' name='pengarang' value='" . $row["pengarang"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='tahun'>Tahun:</label>
                                          <input type='text' class='form-control' id='tahun' name='tahun' value='" . $row["tahun"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='seri'>Nomor Seri:</label>
                                          <input type='text' class='form-control' id='seri' name='seri' value='" . $row["seri"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='isbn'>Nomor ISBN:</label>
                                          <input type='text' class='form-control' id='isbn' name='isbn' value='" . $row["isbn"] . "'>
                                        </div>
                                        <div class='form-group'>
                                          <label for='jumlahBuku'>Jumlah Koleksi Buku:</label>
                                          <input type='text' class='form-control' id='jumlahBuku' name='jumlahBuku' value='" . $row["jumlahBuku"] . "'>
                                        </div>
                                        <button type='submit' class='btn btn-primary btn-sm'>Simpan Perubahan</button>
                                      </form>
                                        </div>
                                        <div class='modal-footer'>
                                          <button type='button' class='btn btn-danger btn-sm' data-dismiss='modal'>Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                      // Modal untuk Hapus Data Buku
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalHapus" . $row["id"] . "'>
                              <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <div class='modal-title'>Hapus Data Buku</div>
                                  </div>
                                  <div class='modal-body'>
                                    <form action='proses/hapus_buku.php' method='POST'>
                                      <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                                      <input type='hidden' class='form-control' id='judul' name='judul' value='" . $row["judul"] . "'>
                                      <p>Anda akan menghapus data buku: <b>" . $row["judul"] . "</b></p>
                                      <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                                      <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Batal</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>";
                    }
                  } else {
                      echo '<tr><td colspan="3">Tidak ada data buku.</td></tr>';
                  }
                  $conn->close();
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.Data Buku -->
          <!-- Tambah Data Buku -->
          <div class="col-md-4 col-12">
            <div class="card">
              <div class="card-header">
                Tambah Data Buku
              </div>
              <div class="card-body">
                <form action="proses/tambah_buku.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="cover">Cover:</label>
                    <input type="text" class="form-control" id="cover" name="cover">
                  </div>
                  <div class="form-group">
                    <label for="judul">Judul:</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                  </div>
                  <div class="form-group">
                    <label for="penerbit">Penerbit:</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                  </div>
                  <div class="form-group">
                    <label for="pengarang">Pengarang:</label>
                    <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                  </div>
                  <div class="form-group">
                    <label for="tahun">Tahun:</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" required>
                  </div>
                  <div class="form-group">
                    <label for="seri">Nomor Seri:</label>
                    <input type="text" class="form-control" id="seri" name="seri" required>
                  </div>
                  <div class="form-group">
                    <label for="isbn">Nomor ISBN:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                  </div>
                  <div class="form-group">
                    <label for="jumlahBuku">Jumlah Koleksi Buku:</label>
                    <input type="text" class="form-control" id="jumlahBuku" name="jumlahBuku" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Tambah Buku</button>
                </form>
              </div>
            </div>
          </div><!-- /. Tambah Data Buku -->
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
        text: 'Berhasil menambahkan data buku.'
      });
    }

    if (successParam === '2') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Berhasil menghapus data buku.'
      });
    }

    if (successParam === '3') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Berhasil memperbarui data buku.'
      });
    }

    if (errorParam === '1') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menambahkan data buku.'
      });
    }

    if (errorParam === '2') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal, judul telah terdaftar.'
      });
    }

    if (errorParam === '3') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menghapus data buku.'
      });
    }

    if (errorParam === '4') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal memperbarui data buku.'
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
    $("#bukuTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>