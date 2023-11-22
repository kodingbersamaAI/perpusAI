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
  <title>Pengguna - PerpusAI</title>

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

        <!-- Data Pengguna -->
        <div class="row">
          <div class="col-md-8 col-12">
            <div class="card">
              <div class="card-header">
                Data Pengguna
              </div>
              <div class="card-body">
                <table id="penggunaTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Query SQL untuk mengambil data pengguna
                  $queryPengguna = "SELECT * FROM pengguna ORDER BY role ASC";
                  $resultPengguna = $conn->query($queryPengguna);

                  if ($resultPengguna->num_rows > 0) {
                    while ($row = $resultPengguna->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["username"] . "</td>";
                      echo "<td>" . $row["role"] . "</td>";
                      echo "<td>";
                      echo "<button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDelete" . $row["username"] . "' alt='Hapus Data Pengguna'><i class='fas fa-trash'></i></button>&nbsp;";
                      echo "</td>";
                      echo "</tr>";
                      // Modal untuk Hapus Data Pengguna
                      echo "<div class='modal fade' tabindex='-1' role='dialog' aria-hidden='true' id='modalDelete" . $row["username"] . "'>
                      <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <div class='modal-title'>Hapus Data Pengguna</div>
                          </div>
                          <div class='modal-body'>
                            <form action='proses/hapus_pengguna.php' method='POST'>
                            <div class='form-group'>
                              <input type='hidden' name='csrf_token' readonly value= '" . generateCSRFToken() . "'>
                              <input type='hidden' class='form-control' id='username' name='username' value='" . $row["username"] . "'>
                              <p>Anda akan menghapus data pengguna: <b>" . $row["username"] . "</b><p>
                              
                            </div>
                              <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                              <button type='button' class='btn btn-secondary btn-sm' data-dismiss='modal'>Batal</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>";
                    }
                  } else {
                      echo '<tr><td colspan="3">Tidak ada data pengguna.</td></tr>';
                  }
                  $conn->close();
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.Data Pengguna -->
          <!-- Tambah Data Pengguna -->
          <div class="col-md-4 col-12">
            <div class="card">
              <div class="card-header">
                Tambah Data Pengguna
              </div>
              <div class="card-body">
                <form action="proses/tambah_pengguna.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                  <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="password" name="password" required>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-secondary" id="togglePassword">
                          <i class="far fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role">
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
                </form>
              </div>
            </div>
          </div><!-- /. Tambah Data Pengguna -->
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
  const passwordInput = document.getElementById('password');
  const togglePasswordButton = document.getElementById('togglePassword');

  togglePasswordButton.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      togglePasswordButton.innerHTML = '<i class="far fa-eye-slash"></i>';
    } else {
      passwordInput.type = 'password';
      togglePasswordButton.innerHTML = '<i class="far fa-eye"></i>';
    }
  });
</script>

<script>
  $(document).ready(function() {
    // Cek apakah parameter success=1 ada di URL
    var successParam = new URLSearchParams(window.location.search).get('success');
    var errorParam = new URLSearchParams(window.location.search).get('error');
    
    if (successParam === '1') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Berhasil menambahkan data pengguna.'
      });
    }

    if (successParam === '2') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Berhasil menghapus data pengguna.'
      });
    }

    if (errorParam === '1') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menambahkan data pengguna.'
      });
    }

    if (errorParam === '2') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal, username telah terdaftar.'
      });
    }

    if (errorParam === '3') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menghapus data pengguna.'
      });
    }

    if (errorParam === '4') {
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
    $("#penggunaTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    })
  });
</script>

<!-- /Script -->
</body>
</html>