<?php
include "koneksi.php";
include "header.php";

mysqli_query($koneksi, "update node set jumlah_kasus=0, ya=0, tidak=0, c1=0, c2=0");
mysqli_query($koneksi, "truncate perhitungan");

mysqli_query($koneksi, "UPDATE `hasil` SET TP=0, TN=0, FP=0, FN=0, akurasi=0, presisi=0, recall=0");

?>
    <h1>Perhitungan Berhasil di Reset</h1>
<?php

include "footer.php";