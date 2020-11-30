<?php
include "koneksi.php";
include "header.php";


$select_data = mysqli_query($koneksi, "select * from klasifikasi_survei");



?>
<h1 align="center">Data Warga hasil klasifikasi</h1>
<table class="table table-hover table-striped">
<thead>
    <tr>
    <th>No</th>
    
    <th>Nama Pasangan Kepala Keluarga</th>
    <th>Luas lantai rumah Kurang dari 40 M²</th>
    <th>Dinding Rumah Tembok tanpa Plester</th>
    <th>Pekerjaan Tenaga Kasar/Tidak Punya Pekerjaan  </th>
    <th>Tabungan Simpanan Perbulan < Rp 1.000.000</th>
    <th>Jenis Lantai rumah Plester Semen</th>
    <th>Tak Punya Jamban Keluarga </th>
    <th>Sumber Air Bersih Sumur</th>
    <th>Tanggal Survei</th>
    <th>Outcome</th>
    </tr>
</thead>
<tbody>

    <?php 
    $angka_awal = 0;
    $angka_selanjutnya = $angka_awal + 1;
    $batas_menampilkan_data = 20;

        if(isset($_GET['batas']))
    {
        $batas_menampilkan_data = $_GET['batas'];
    }

    //jika terdapat nilai halaman di URL, gunakan untuk mengganti nilai dafault dari $default_index
    if(isset($_GET['halaman']))
    {
        $default_index = ($_GET['halaman']-1) * $default_batas;
    }

    while($data = mysqli_fetch_array($select_data)): 
        
        ?>
        <tr>
            <td><?= $angka_selanjutnya;  ?> </td>
           
            <td><?= $data['kepala_rumah_tangga']; ?></td>
            <td><?= $data['luas_rumah_kurang_dari_40m']; ?></td>
            <td><?= $data['dinding_rumah_tembok_tanpa_plester']; ?></td>
            <td><?= $data['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan']; ?></td>
            <td><?= $data['tabungan_simpanan_perbulan_kurang_dari_satujuta']; ?></td>
            <td><?= $data['jenis_lantai_rumah_plester_semen']; ?></td>
            <td><?= $data['tak_punya_jamban_keluarga']; ?></td>
            <td><?= $data['sumber_air_bersih_sumur']; ?></td>
            <td><?= $data['tanggal_survei']; ?></td>
            <td><?= $data['klasifikasi']; ?></td>
            
     
        </tr>


    <?php 
    $angka_selanjutnya++;
    endwhile; 
   

    ?>
</tbody>
</table>
<!-- <form action="cetak-warga.php">
    <a href="cetak-warga.php"><button type="submit" class="btn btn-primary">  Cetak Data warga</button></a>
   
</form> -->
<!-- <form method="get" >
     <input type="submit" name="submit">
</form> -->

<br>
<?php 
include "footer.php";
?>