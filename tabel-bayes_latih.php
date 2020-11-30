<?php
include "koneksi.php";
include "header.php";
$select_data = mysqli_query($koneksi, "SELECT * FROM `data_latih` JOIN `perhitungan_latih` ON (`data_latih`.`id`=`perhitungan_latih`.`id`)");

?>
<h1>Tabel Bayes</h1>
<div class="table-responsive">
<table class="table table-bordered">
<thead>
    <tr>
    <th rowspan=2 style="vertical-align:middle;">No</th>
    <th colspan=3>Batas Kategori</th>
    <th colspan=3>Kategori Taraf</th>
    
    <th colspan=2>Total</th>
    <th rowspan=2 style="vertical-align:middle;">Klasifikasi</th>
    <th rowspan=2 style="vertical-align:middle;">Outcome</th>
    <!-- <th rowspan=2 style="vertical-align:middle;">Kriteria</th> -->
    </tr>
    <tr>
    <th>Atribut</th>
    <th>C1</th>
    <th>C2</th>

    <th>Atribut</th>
    <th>C1</th>
    <th>C2</th>



    <th>C1</th>
    <th>C2</th>
    </tr>
</thead>
<tbody>
    <?php while($data = mysqli_fetch_array($select_data)): ?>
    <tr>
        <td><?= $data['id']; ?></td>
        <td><?= $data['batas_kategori']; ?></td>
        <td><?= $data['batas_kategori_c1']; ?></td>
        <td><?= $data['batas_kategori_c2']; ?></td>
        <td><?= $data['kategori_taraf']; ?></td>
        <td><?= $data['kategori_taraf_c1']; ?></td>
        <td><?= $data['kategori_taraf_c2']; ?></td>
        
        <td><?= $data['total_c1']; ?></td>
        <td><?= $data['total_c2']; ?></td>
        <td><?= $data['klasifikasi']; ?></td>
        <td><?= $data['perlu_bantuan_lebih']; ?></td>
        <!-- <td><?= $data['kriteria']; ?></td> -->
    </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>
<?php
include "footer.php";
?>