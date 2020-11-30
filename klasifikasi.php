<?php 
	include "koneksi.php";
include "header.php";
mysqli_query($koneksi, "truncate akhir");
$select_data = mysqli_query($koneksi, "select * from warga");
$satu = 0;
$dua = 0;
$tiga = 0;
$empat = 0;
$lima = 0;
$enam = 0;
$tujuh = 0;

while ($data = mysqli_fetch_array($select_data)) {
	if ($data['luas_rumah_kurang_dari_40m']="ya") {
		$satu = 1;
	} else {
		$satu = 0;
	}

	if ($data['dinding_rumah_tembok_tanpa_plester']=="ya") {
		$dua = 1;
	} else {
		$dua = 0;
	}

	if ($data['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan']=="ya") {
		$tiga = 1;
	} else {
		$tiga = 0;
	}
	if ($data['tabungan_simpanan_perbulan_kurang_dari_satujuta']=="ya") {
		$empat = 1;
	} else {
		$empat = 0;
	}
	if ($data['jenis_lantai_rumah_plester_semen']=="ya") {
		$lima = 1;
	} else {
		$lima = 0;
	}
	if ($data['tak_punya_jamban_keluarga']=="ya") {
		$enam = 1;
	} else {
		$enam = 0;
	}
	if ($data['sumber_air_bersih_sumur']=="ya") {
		$tujuh = 1;
	} else {
		$tujuh = 0;
	}

	$jumlah_ya = $satu+$dua+$tiga+$empat+$lima+$enam+$tujuh;
	
	$batas_kategori_c1 = 0;
   $batas_kategori_c2 = 0;

   $kategori_taraf_c1 = 0;
   $kategori_taraf_c2 = 0;

   if ($jumlah_ya >= 1 && $jumlah_ya <= 3) {
       $batas_kategori_c1 = 0; 
       $batas_kategori_c2 = 0.58653846153846;
   } elseif ($jumlah_ya >= 4 && $jumlah_ya <= 5) {
       $batas_kategori_c1 = 0.41279069767442; 
       $batas_kategori_c2 = 0.57692307692308;
   } elseif ($jumlah_ya >= 6 && $jumlah_ya <= 7) {
       $batas_kategori_c1 = 0.48837209302326; 
       $batas_kategori_c2 = 0;
   }

   if ($jumlah_ya <= 3 && $data['tabungan_simpanan_perbulan_kurang_dari_satujuta']=="tidak") {
       $kategori_taraf_c1 = 0.040697674418605;
       $kategori_taraf_c2 = 0.58653846153846;
   } elseif ($jumlah_ya >= 4 && $jumlah_ya <= 5 && $data['tabungan_simpanan_perbulan_kurang_dari_satujuta']=="ya") {
       $kategori_taraf_c1 = 0.41279069767442;
       $kategori_taraf_c2 = 0.57692307692308;
   } elseif ($jumlah_ya >= 6 && $jumlah_ya <= 7 && $data['tabungan_simpanan_perbulan_kurang_dari_satujuta'] == "tidak") {
       $kategori_taraf_c1 = 0.41279069767442;
       $kategori_taraf_c2 = 0.57692307692308;
   } elseif ($jumlah_ya >= 6 && $jumlah_ya <= 7 && $data['tabungan_simpanan_perbulan_kurang_dari_satujuta'] == "ya") {
       $kategori_taraf_c1 = 0.44767441860465;
       $kategori_taraf_c2 = 0;
   }
   $c1 = 0.56159420289855;
   $c2 = 0.43840579710145;

   $total_c1 = $batas_kategori_c1 * $kategori_taraf_c1 * $c1; 
   $total_c2 = $batas_kategori_c2 * $kategori_taraf_c2 * $c2;

   // if ($total_c1 > $total_c2) {
   //     $perlu_bantuan_lebih = "ya";
   // } else {
   //      $perlu_bantuan_lebih = "tidak";
   // }
 $nama = $data['kepala_rumah_tangga'];
 $luas = $data['luas_rumah_kurang_dari_40m'];
 $dinding = $data['dinding_rumah_tembok_tanpa_plester'];
 $pekerjaan = $data['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan'];
 $tabungan = $data['tabungan_simpanan_perbulan_kurang_dari_satujuta'];
 $jenis = $data['jenis_lantai_rumah_plester_semen'];
 $jamban = $data['tak_punya_jamban_keluarga'];
 $sumber = $data['sumber_air_bersih_sumur'];
 $tanggal = $data['tanggal_survei'];

   if ($jumlah_ya <5) {
   	$perlu_bantuan_lebih = "tidak";
   } else {
   	$perlu_bantuan_lebih = "ya";
   }
   // echo $nama . $jumlah_ya . "  Batas kategori  ". $batas_kategori_c1. "   ".$batas_kategori_c2."  Kategori taraf ".$kategori_taraf_c1."   ".$kategori_taraf_c2. "total c1 : " . $total_c1 . "total c2 : ". $total_c2 . "perlu bantuan lebih : ". $perlu_bantuan_lebih ."</br>";

  
   mysqli_query($koneksi, "INSERT INTO `akhir`(`kepala_rumah_tangga`,`klasifikasi`) VALUES ('$nama','$perlu_bantuan_lebih')");
   mysqli_query($koneksi, "INSERT INTO `klasifikasi_survei`(`kepala_rumah_tangga`, `luas_rumah_kurang_dari_40m`, `dinding_rumah_tembok_tanpa_plester`, `pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan`, `tabungan_simpanan_perbulan_kurang_dari_satujuta`, `jenis_lantai_rumah_plester_semen`, `tak_punya_jamban_keluarga`, `sumber_air_bersih_sumur`, `tanggal_survei`, `klasifikasi`) 
   	VALUES ('$nama','$luas','$dinding','$pekerjaan','$tabungan','$jenis','$jamban','$sumber','$tanggal','$perlu_bantuan_lebih')");
  	
}
// $ambil = mysqli_query($koneksi, "select * from warga,akhir where warga.kepala_rumah_tangga = akhir.kepala_rumah_tangga");
// while ( $dataku = mysqli_fetch_array($ambil)) {


// 	mysqli_query($koneksi, "INSERT INTO `klasifikasi_survei`(`id`,`kepala_rumah_tangga`, `luas_rumah_kurang_dari_40m`, `dinding_rumah_tembok_tanpa_plester`, `pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan`, `tabungan_simpanan_perbulan_kurang_dari_satujuta`, `jenis_lantai_rumah_plester_semen`, `tak_punya_jamban_keluarga`, `sumber_air_bersih_sumur`, `tanggal_survei`, `klasifikasi`) 
//                 VALUES (".$dataku['id'].",".$dataku['kepala_rumah_tangga'].",".$dataku['luas_rumah_kurang_dari_40m'].",".$dataku['dinding_rumah_tembok_tanpa_plester'].",".$dataku['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan'].",".$dataku['tabungan_simpanan_perbulan_kurang_dari_satujuta'].",".$dataku['jenis_lantai_rumah_plester_semen'].",".$dataku['tak_punya_jamban_keluarga'].",
//                 ".$dataku['sumber_air_bersih_sumur'].",".$dataku['tanggal_survei'].",".$dataku['klasifikasi'].")");


	
		
		echo "<center><h1>Data Berhasil Disimpan</h1></center>";
 ?>

