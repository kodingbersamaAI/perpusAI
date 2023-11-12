<?php
require('../../server/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);

    $queryJudul = "SELECT judul FROM buku WHERE judul LIKE '%$input%'";
    $resultJudul = $conn->query($queryJudul);

    if ($resultJudul->num_rows > 0) {
        while ($row = $resultJudul->fetch_assoc()) {
            echo '<div class="judul-option" onmouseover="highlightOption(this)" onmouseout="unhighlightOption(this)" onclick="selectOption(\'' . $row['judul'] . '\')">' . $row['judul'] . '</div>';
        }
    } else {
        echo '<div class="no-result">Tidak ada hasil.</div>';
    }
}
?>