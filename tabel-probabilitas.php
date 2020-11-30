<?php
error_reporting(0);
include "koneksi.php";
include "header.php";
$select_atribut = mysqli_query($koneksi, "select * from node");
$select_data = mysqli_query($koneksi, "select (select count(*) from data) as total_kasus, (select count(*) from data where outcome='Hidup') as total_hidup, (select count(*) from data where outcome='Meninggal') as total_meninggal");

$semua_data = [];
$totalan = mysqli_fetch_array($select_data);
$total_kasus = $totalan['total_kasus'];
$total_hidup = $totalan['total_hidup'];
$total_meninggal = $totalan['total_meninggal'];

while($data = mysqli_fetch_array($select_atribut)) {
    $semua_data[$data['grup']][] = [
        'atribut' => $data['atribut'],
        'jumlah_kasus' => $data['jumlah_kasus'],
        'hidup' => $data['hidup'],
        'meninggal' => $data['meninggal'],
        'c1' => $data['c1'],
        'c2' => $data['c2'],
    ];
}
$total_c1 = is_nan($total_hidup/$total_kasus) ? 0 : $total_hidup/$total_kasus;
$total_c2 = is_nan($total_meninggal/$total_kasus) ? 0 : $total_meninggal/$total_kasus;
?>
<h1>Tabel Probabilitas</h1>
<table class="table">
<thead>
    <tr>
    <th>Atribut</th>
    <th>Jumlah Kasus</th>
    <th>Hidup</th>
    <th>Meninggal</th>
    <th>C1(Hidup)</th>
    <th>C2(Meninggal)</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Total</td>
        <td><?= $total_kasus ?></td>
        <td><?= $total_hidup ?></td>
        <td><?= $total_meninggal ?></td>
        <td><?= $total_c1 ?></td>
        <td><?= $total_c2 ?></td>
    </tr>
    <?php foreach($semua_data as $grup => $data): ?>
    <tr>
        <th colspan="6"><?= $grup ?></th>
    </tr>
        <?php foreach($data as $val): ?>
            <tr>
                <td><?= $val['atribut']; ?></td>
                <td><?= $val['jumlah_kasus']; ?></td>
                <td><?= $val['hidup']; ?></td>
                <td><?= $val['meninggal']; ?></td>
                <td><?= $val['c1']; ?></td>
                <td><?= $val['c2']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</tbody>
</table>

<?php
include "footer.php";
?>