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
  <title>Laporan - PerpusAI</title>

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

        <!-- Rekap Transaksi -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                Rekap Transaksi
              </div>
              <div class="card-body">
                <table id="rekapTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Peminjam</th>
                      <th>Buku</th>
                      <th>Batas Peminjaman</th>
                      <th>Denda</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php
                  // Query SQL untuk mengambil data transaksi
                  $queryRekap = "SELECT * FROM transaksi ORDER BY username ASC";
                  $resultRekap = $conn->query($queryRekap);

                  if ($resultRekap->num_rows > 0) {
                    while ($row = $resultRekap->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["username"] . "</td>";
                      echo "<td>" . $row["judul"] . "</td>";
                      echo "<td>" . $row["jatuhTempo"] . "</td>";
                      echo "<td>" . $row["denda"] . "</td>";
                      echo "<td>" . $row["status"] . "</td>";
                    }
                  } else {
                      echo '<tr><td colspan="3">Tidak ada data transaksi.</td></tr>';
                  }
                  $conn->close();
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!-- /.Rekap Rekap -->
        </div><!-- /.row -->

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
    $("#rekapTable").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#rekapTable_wrapper .col-md-6:eq(0)');
  });
</script>

<!-- /Script -->
</body>
</html>