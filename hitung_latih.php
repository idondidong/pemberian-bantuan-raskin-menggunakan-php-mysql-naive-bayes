<?php
include "koneksi.php";
include "header.php";
// ambil semua data atribut dari tabel node
$select_atribut = mysqli_query($koneksi, "select * from node_latih");

$semua_probabilitas = []; // semua atribut akan di simpan di variabel ini setelah dilakukan perhitungan
$total_kasus = 0; // jumlah total dari kasus akan di simpan di variabel ini
$total_ya = 0; // jumlah total dari kasus yang hidup akan di simpan di variabel ini
$total_tidak = 0; // jumlah total dari kasus yang meninggal akan di simpan di variabel ini

while($data = mysqli_fetch_array($select_atribut)) { // perulangan setiap record untuk tabel node
    $grup = strtolower(str_replace(" ", "_", $data['grup'])); // ambil grup dari record lalu di rubah ke lowercase dan setiap spasi di ganti underscore seperti "Gejala Miokard" menjadi "gejala_miokard"
    // ambil jumlah dari semua data di dataset seperti jumlah yang hidup dan meninggal yang sesuai dengan atribut dari record seperti gejala_miokard="Ya"
    $select_per_atribut = mysqli_query($koneksi, "select '".$data['atribut']."' as atribut, '".$data['grup']."' as grup, (select count(*) from data_latih where ".$grup."='".$data['atribut']."') as jumlah_kasus, (select count(*) from data_latih where ".$grup."='".$data['atribut']."' and perlu_bantuan_lebih='ya') as ya, (select count(*) from data_latih where ".$grup."='".$data['atribut']."' and perlu_bantuan_lebih='tidak') as tidak");


// $select_atribut = mysqli_query($koneksi, "select * from node_latih");
$select_data = mysqli_query($koneksi, "select (select count(*) from data_latih) as total_kasus, (select count(*) from data_latih where perlu_bantuan_lebih='ya') as total_ya, (select count(*) from data_latih where perlu_bantuan_lebih='tidak') as total_tidak");

$semua_data = [];
$totalan = mysqli_fetch_array($select_data);
$total_kasus = $totalan['total_kasus'];
$total_ya = $totalan['total_ya'];
$total_tidak = $totalan['total_tidak'];
$bantuan_ya = 155;
$bantuan_tidak = 121;

    if ($select_per_atribut) {
        // hasil querynya seperti |"Ya", "Gejala Miokard", 18, 10, 8| yang di pecah menjadi array dengan fungsi dibawah
        $data_per_atribut = mysqli_fetch_array($select_per_atribut);
        $jumlah_kasus = $data_per_atribut['jumlah_kasus']; // ambil jumlah kasus dari query tadi
        $ya = $data_per_atribut['ya']; // ambil jumlah kasus yang hidup
        $tidak = $data_per_atribut['tidak']; // ambil jumlah kasus yang meninggal
        $c1 = $ya/$bantuan_ya; // hitung class 1
        $c2 = $tidak/$bantuan_tidak; // hitung class 2
        // dari hasil perhitungan di atas, data akan di simpan kembali ke tabel node
        mysqli_query($koneksi, "update node_latih set jumlah_kasus=" . $jumlah_kasus . ", ya=" . $ya . ", tidak=" . $tidak . ", c1='". $c1 ."', c2='".$c2."' where atribut='".$data_per_atribut['atribut']."' and grup='".$data_per_atribut['grup']."'");
        // hasil perhitungan di simpan ke variable probabilitas karena akan digunakan di perhitungan selanjunya
        $semua_probabilitas[$grup][$data_per_atribut['atribut']] = [
            'jumlah_kasus' => $jumlah_kasus,
            'ya' => $ya,
            'tidak' => $tidak,
            'c1' => $c1,
            'c2' => $c2,
        ];
        $total_kasus = $total_kasus + $jumlah_kasus; // jumlahkan total kasus sebelumnya dengan kasus di record saat ini
        $total_ya = $total_ya + $ya; // jumlahkan total kasus yang hidup sebelumnya dengan kasus yang hidup saat ini
        $total_tidak = $total_tidak + $tidak; // jumlahkan total kasus yang meninggal sebelumnya dengan meninggal yang hidup saat ini
    }
}

// ambil semua dataset
$select_data = mysqli_query($koneksi, "select * from data_latih");

$TP = 0; // simpan kasus yang True Positive
$TN = 0; // simpan kasus yang True Negative
$FP = 0; // simpan kasus yang False Positive
$FN = 0; // simpan kasus yang False Negative
$c1ambil = 0.56159420289855;
$c2ambil = 0.43840579710145;

while($data = mysqli_fetch_array($select_data)) { // perulangan setiap record dari dataset
    // jumlahkan semua c1 dari atribut yang sesuai dengan dataset, dan data c1 diambil dari atribut yang di simpan di variabel probabilitas di perhitungan sebelumnya
    $total_c1 = $semua_probabilitas['batas_kategori'][$data['batas_kategori']]['c1'] * 
        $semua_probabilitas['kategori_taraf'][$data['kategori_taraf']]['c1'] * $c1ambil;
    // jumlahkan semua c2 dari atribut yang sesuai dengan dataset, dan data c2 diambil dari atribut yang di simpan di variabel probabilitas di perhitungan sebelumnya
    $total_c2 = $semua_probabilitas['batas_kategori'][$data['batas_kategori']]['c2'] * 
        $semua_probabilitas['kategori_taraf'][$data['kategori_taraf']]['c2'] *$c2ambil;
    // perbandingan dari total c1 dan c2 yang menentukan klasifikasi hidup dan meninggal
    $klasifikasi = $total_c1 > $total_c2 ? "ya" : "tidak";
    // menentukan record dataset dan hasil klasifikasi masuk kriteria yang mana
    if ($klasifikasi == "ya" && $data['perlu_bantuan_lebih'] == "ya") {
        $kriteria = "TP";
        $TP = $TP + 1; // jika masuk kriteria ke True Positive maka variabel TP ditambah 1
    } elseif ($klasifikasi == "ya" && $data['perlu_bantuan_lebih'] == "tidak") {
        $kriteria = "FN";
        $FN = $FN + 1; // jika masuk kriteria ke False Negative maka variabel FN ditambah 1
    } elseif ($klasifikasi == "tidak" && $data['perlu_bantuan_lebih'] == "ya") {
        $kriteria = "FP";
        $FP = $FP + 1; // jika masuk kriteria ke False Positive maka variabel FP ditambah 1
    } elseif ($klasifikasi == "tidak" && $data['perlu_bantuan_lebih'] == "tidak") {
        $kriteria = "TN";
        $TN = $TN + 1; // jika masuk kriteria ke True Negative maka variabel TN ditambah 1
    }
    // simpan hasil klasifikasi tadi ke tabel perhitungan
    mysqli_query($koneksi, "INSERT INTO `perhitungan_latih`(`id`, `batas_kategori_c1`, `batas_kategori_c2`, `kategori_taraf_c1`, `kategori_taraf_c2`, `total_c1`, `total_c2`, `klasifikasi`, `kriteria`) VALUES 
    (".$data['id'].",
    ".$semua_probabilitas['batas_kategori'][$data['batas_kategori']]['c1'].",
    ".$semua_probabilitas['batas_kategori'][$data['batas_kategori']]['c2'].",
    ".$semua_probabilitas['kategori_taraf'][$data['kategori_taraf']]['c1'].",
    ".$semua_probabilitas['kategori_taraf'][$data['kategori_taraf']]['c2'].",

    ".$total_c1.",".$total_c2.",'".$klasifikasi."','".$kriteria."')");
}

$akurasi = (($TP + $TN) / ($TP+$TN+$FP+$FN)) * 100; // hitung akurasi dari perhitungan sebelumnya
$presisi = ($TP / ($TP + $FP)) * 100; // hitung presisi dari perhitungan sebelumnya
$recall = ($TP / ($TP + $FN)) * 100; // hitung recall dari perhitungan sebelumnya
// hasil dari perhitungan akurasi, presisi, dan recall di simpan ke tabel hasil
mysqli_query($koneksi, "UPDATE `hasil_latih` SET TP='$TP', TN='$TN', FP='$FP', FN='$FN', akurasi='$akurasi', presisi='$presisi', recall='$recall'");


?>
    <h1>Perhitungan Berhasil</h1>
<?php

include "footer.php";