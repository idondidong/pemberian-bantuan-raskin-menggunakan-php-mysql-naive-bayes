<?php
include "koneksi.php";
include "header.php";

// ambil semua data atribut dari tabel node
$select_atribut = mysqli_query($koneksi, "select * from node_latih");

$semua_data = [];

while($data = mysqli_fetch_array($select_atribut)) {
    // tiap record dari atribut di simpan ke variabel semua data
    // hal ini akan digunakan untuk sistem pakar
    $semua_data[$data['grup']][$data['atribut']] = [
        'c1' => $data['c1'],
        'c2' => $data['c2'],
    ];
}
?>

<h1>Uji Coba Pakar</h1>
<form method="post">

    <div class="form-group row">
        <label class="col-form-label col-sm-5">Nama</label>
        <div class="col-sm-1">
            <input type="text" name="kepala_rumah_tangga">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">No KTP</label>
        <div class="col-sm-3">
            <input type="text" name="noktp">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">luas_rumah_kurang_dari_40m</label>
        <div class="col-sm-3">
            <select name="luas_rumah_kurang_dari_40m">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">dinding_rumah_tembok_tanpa_plester</label>
        <div class="col-sm-3">
           
            <select name="dinding_rumah_tembok_tanpa_plester">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan</label>
        <div class="col-sm-3">
            
            <select name="pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">tabungan_simpanan_perbulan_kurang_dari_satujuta</label>
        <div class="col-sm-3">
            
            <select name="tabungan_simpanan_perbulan_kurang_dari_satujuta">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">jenis_lantai_rumah_plester_semen</label>
        <div class="col-sm-3">
            
            <select name="jenis_lantai_rumah_plester_semen">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">tak_punya_jamban_keluarga</label>
        <div class="col-sm-3">
           
            <select name="tak_punya_jamban_keluarga">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">sumber_air_bersih_sumur</label>
        <div class="col-sm-3">
            
            <select name="sumber_air_bersih_sumur">
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-form-label col-sm-5">Total "Ya"</label>
        <div class="col-sm-3">
            <input type="number" name="jumlahya">
            
        </div>
    </div>


<br>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-7">
            <button type="submit" name="submit" class="btn btn-primary">Tambah Warga</button>
        </div>
    </div>
</form>
<br>
<br>

<?php

if (isset($_POST['submit'])) {
   
   $kepala_rumah_tangga = $_POST['kepala_rumah_tangga'];
   $noktp = $_POST['noktp'];
   $luas_rumah_kurang_dari_40m = $_POST['luas_rumah_kurang_dari_40m'];
   $dinding_rumah_tembok_tanpa_plester = $_POST['dinding_rumah_tembok_tanpa_plester'];
   $pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan = $_POST['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan'];
   $tabungan_simpanan_perbulan_kurang_dari_satujuta = $_POST['tabungan_simpanan_perbulan_kurang_dari_satujuta'];
   $jenis_lantai_rumah_plester_semen = $_POST['jenis_lantai_rumah_plester_semen'];
   $tak_punya_jamban_keluarga = $_POST['tak_punya_jamban_keluarga'];
   $sumber_air_bersih_sumur = $_POST['sumber_air_bersih_sumur'];
   $jumlahya = $_POST['jumlahya'];
   
   $batas_kategori_c1 = 0;
   $batas_kategori_c2 = 0;

   $kategori_taraf_c1 = 0;
   $kategori_taraf_c2 = 0;

   if ($jumlahya >= 1 && $jumlahya <= 3) {
       $batas_kategori_c1 = 0; 
       $batas_kategori_c2 = 0.50961538461538;
   } elseif ($jumlahya >= 4 && $jumlahya <= 5) {
       $batas_kategori_c1 = 0.43604651162791; 
       $batas_kategori_c2 = 0.49038461538462;
   } elseif ($jumlahya >= 6 && $jumlahya <= 7) {
       $batas_kategori_c1 = 0.56395348837209; 
       $batas_kategori_c2 = 0;
   }

   if ($jumlahya <= 3 && $tabungan_simpanan_perbulan_kurang_dari_satujuta == "tidak") {
       $kategori_taraf_c1 = 0.063953488372093;
       $kategori_taraf_c2 = 0.50961538461538;
   } elseif ($jumlahya >= 4 && $jumlahya <= 5) {
       $kategori_taraf_c1 = 0.43604651162791;
       $kategori_taraf_c2 = 0.49038461538462;
   } elseif ($jumlahya >= 6 && $jumlahya <= 7 && $tabungan_simpanan_perbulan_kurang_dari_satujuta == "tidak") {
       $kategori_taraf_c1 = 0.063953488372093;
       $kategori_taraf_c2 = 0.50961538461538;
   } elseif ($jumlahya >= 6 && $jumlahya <= 7 && $tabungan_simpanan_perbulan_kurang_dari_satujuta == "ya") {
       $kategori_taraf_c1 = 0.5;
       $kategori_taraf_c2 = 0;
   }
   $c1 = 0.6231884057971;
   $c2 = 0.3768115942029;

   $total_c1 = $batas_kategori_c1 * $kategori_taraf_c1 * $c1; 
   $total_c2 = $batas_kategori_c2 * $kategori_taraf_c2 * $c2;

   if ($total_c1 > $total_c2) {
       $perlu_bantuan_lebih = "ya";
   } else {
        $perlu_bantuan_lebih = "tidak";
   }
   

   $warga = mysqli_query ($koneksi, "INSERT INTO `warga`(`kepala_rumah_tangga`, `luas_rumah_kurang_dari_40m`, `dinding_rumah_tembok_tanpa_plester`, `pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan`, `tabungan_simpanan_perbulan_kurang_dari_satujuta`, `jenis_lantai_rumah_plester_semen`, `tak_punya_jamban_keluarga`, `sumber_air_bersih_sumur`,`perlu_bantuan_lebih`) VALUES ('$kepala_rumah_tangga','$luas_rumah_kurang_dari_40m','$dinding_rumah_tembok_tanpa_plester','$pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan','$tabungan_simpanan_perbulan_kurang_dari_satujuta','$jenis_lantai_rumah_plester_semen', '$tak_punya_jamban_keluarga','$sumber_air_bersih_sumur','$perlu_bantuan_lebih')") ;

   $user = mysqli_query($koneksi, "INSERT INTO `pengguna`(`username`, `password`, `nama`) VALUES ('$noktp',md5('$noktp'),'$kepala_rumah_tangga')");

   

 echo "<h1>Total C1 : " .$total_c1. "</h1>";
 echo "<h1>Total C2 : " .$total_c2. "</h1>";
 echo "<h1>Hasil Klasifikasi : <button type='button' class='btn btn-primary'>".$perlu_bantuan_lebih."</button></h1> ";

 
}
?>







