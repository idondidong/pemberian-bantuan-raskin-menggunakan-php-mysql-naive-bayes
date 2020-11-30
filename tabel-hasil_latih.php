<?php
include "koneksi.php";
include "header.php";
$select_hasil = mysqli_query($koneksi, "select * from hasil_latih");
$data = mysqli_fetch_array($select_hasil);
?>
<h1>Tabel Hasil</h1>

<div class="row">
    <div class="col-md">
        <table class="table">
        <thead>
            <tr>
            <th>Kriteria</th>
            <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>TP</td>
                <td><?= $data['TP'] ?></td>
            </tr>
            <tr>
                <td>TN</td>
                <td><?= $data['TN'] ?></td>
            </tr>
            <tr>
                <td>FP</td>
                <td><?= $data['FP'] ?></td>
            </tr>
            <tr>
                <td>FN</td>
                <td><?= $data['FN'] ?></td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="col-md">
        <table class="table">
        <tbody>
            <tr>
                <td>Akurasi</td>
                <td><?= $data['akurasi'] ?>%</td>
            </tr>
            <tr>
                <td>Presisi</td>
                <td><?= $data['presisi'] ?>%</td>
            </tr>
            <tr>
                <td>Recall</td>
                <td><?= $data['recall'] ?>%</td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
<?php
include "footer.php";
?>