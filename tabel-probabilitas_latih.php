<?php
error_reporting(0);
include "koneksi.php";
include "header.php";
$select_atribut = mysqli_query($koneksi, "select * from node_latih");
$select_data = mysqli_query($koneksi, "select (select count(*) from data_latih) as total_kasus, (select count(*) from data_latih where perlu_bantuan_lebih='ya') as total_ya, (select count(*) from data_latih where perlu_bantuan_lebih='tidak') as total_tidak");

$semua_data = [];
$totalan = mysqli_fetch_array($select_data);
$total_kasus = $totalan['total_kasus'];
$total_ya = $totalan['total_ya'];
$total_tidak = $totalan['total_tidak'];

while($data = mysqli_fetch_array($select_atribut)) {
    $semua_data[$data['grup']][] = [
        'atribut' => $data['atribut'],
        'jumlah_kasus' => $data['jumlah_kasus'],
        'ya' => $data['ya'],
        'tidak' => $data['tidak'],
        'c1' => $data['c1'],
        'c2' => $data['c2'],
    ];
}
$total_c1 = is_nan($total_ya/$total_kasus) ? 0 : $total_ya/$total_kasus;
$total_c2 = is_nan($total_tidak/$total_kasus) ? 0 : $total_tidak/$total_kasus;

$atribut_c1 = is_nan($total_ya/$totalan['total_ya']) ? 0 : $total_ya/$totalan['total_ya'];
$atribut_c2 = is_nan($total_tidak/$totalan['total_tidak']) ? 0 : $total_tidak/$totalan['total_tidak'];
?>

<h1>Tabel Probabilitas</h1>
<table class="table">
<thead>
    <tr>
    <th>Atribut</th>
    <th>Jumlah Kasus</th>
    <th>Ya</th>
    <th>Tidak</th>
    <th>C1(Ya)</th>
    <th>C2(Tidak)</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Total</td>
        <td><?= $total_kasus ?></td>
        <td><?= $total_ya ?></td>
        <td><?= $total_tidak ?></td>
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
                <td><?= $val['ya']; ?></td>
                <td><?= $val['tidak']; ?></td>
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