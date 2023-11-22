<?php
require('../../server/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);

    $queryUsername = "SELECT username FROM pengguna WHERE username LIKE '%$input%'";
    $resultUsername = $conn->query($queryUsername);

    if ($resultUsername->num_rows > 0) {
        while ($row = $resultUsername->fetch_assoc()) {
            echo '<div class="username-option" onmouseover="highlightOption(this)" onmouseout="unhighlightOption(this)" onclick="selectOption(\'' . $row['username'] . '\')">' . $row['username'] . '</div>';
        }
    } else {
        echo '<div class="no-result">Tidak ada hasil.</div>';
    }
}
?>