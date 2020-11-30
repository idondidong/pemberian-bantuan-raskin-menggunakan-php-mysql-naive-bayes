<?php
include "koneksi.php";
include "header.php";
// ambil semua data atribut dari tabel node
$select_atribut = mysqli_query($koneksi, "select * from node_latih");

$semua_probabilitas = []; // semua atribut akan di simpan di variabel ini setelah dilakukan perhitungan
$total_kasus = 0; // jumlah total dari kasus akan di simpan di variabel ini
$total_hidup = 0; // jumlah total dari kasus yang hidup akan di simpan di variabel ini
$total_meninggal = 0; // jumlah total dari kasus yang meninggal akan di simpan di variabel ini

while($data = mysqli_fetch_array($select_atribut)) { // perulangan setiap record untuk tabel node
    $grup = strtolower(str_replace(" ", "_", $data['grup'])); // ambil grup dari record lalu di rubah ke lowercase dan setiap spasi di ganti underscore seperti "Gejala Miokard" menjadi "gejala_miokard"
    // ambil jumlah dari semua data di dataset seperti jumlah yang hidup dan meninggal yang sesuai dengan atribut dari record seperti gejala_miokard="Ya"
    $select_per_atribut = mysqli_query($koneksi, "select '".$data['atribut']."' as atribut, '".$data['grup']."' as grup, (select count(*) from data where ".$grup."='".$data['atribut']."') as jumlah_kasus, (select count(*) from data where ".$grup."='".$data['atribut']."' and outcome='Hidup') as hidup, (select count(*) from data where ".$grup."='".$data['atribut']."' and outcome='Meninggal') as meninggal");


$select_data = mysqli_query($koneksi, "select (select count(*) from data) as total_kasus, (select count(*) from data where outcome='Hidup') as total_hidup, (select count(*) from data where outcome='Meninggal') as total_meninggal");

$semua_data = [];
$totalan = mysqli_fetch_array($select_data);
$total_kasus = $totalan['total_kasus'];
$total_hidup = $totalan['total_hidup'];
$total_meninggal = $totalan['total_meninggal'];

    if ($select_per_atribut) {
        // hasil querynya seperti |"Ya", "Gejala Miokard", 18, 10, 8| yang di pecah menjadi array dengan fungsi dibawah
        $data_per_atribut = mysqli_fetch_array($select_per_atribut);
        $jumlah_kasus = $data_per_atribut['jumlah_kasus']; // ambil jumlah kasus dari query tadi
        $hidup = $data_per_atribut['hidup']; // ambil jumlah kasus yang hidup
        $meninggal = $data_per_atribut['meninggal']; // ambil jumlah kasus yang meninggal
        $c1 = $hidup; // hitung class 1
        $c2 = $meninggal; // hitung class 2
        // dari hasil perhitungan di atas, data akan di simpan kembali ke tabel node
        mysqli_query($koneksi, "update node set jumlah_kasus=" . $jumlah_kasus . ", hidup=" . $hidup . ", meninggal=" . $meninggal . ", c1='". $c1 ."', c2='".$c2."' where atribut='".$data_per_atribut['atribut']."' and grup='".$data_per_atribut['grup']."'");
        // hasil perhitungan di simpan ke variable probabilitas karena akan digunakan di perhitungan selanjunya
        $semua_probabilitas[$grup][$data_per_atribut['atribut']] = [
            'jumlah_kasus' => $jumlah_kasus,
            'hidup' => $hidup,
            'meninggal' => $meninggal,
            'c1' => $c1/$total_hidup,
            'c2' => $c2/$total_meninggal,
        ];
        $total_kasus = $total_kasus + $jumlah_kasus; // jumlahkan total kasus sebelumnya dengan kasus di record saat ini
        $total_hidup = $total_hidup + $hidup; // jumlahkan total kasus yang hidup sebelumnya dengan kasus yang hidup saat ini
        $total_meninggal = $total_meninggal + $meninggal; // jumlahkan total kasus yang meninggal sebelumnya dengan meninggal yang hidup saat ini
    }
}

// ambil semua dataset
$select_data = mysqli_query($koneksi, "select * from data");

$TP = 0; // simpan kasus yang True Positive
$TN = 0; // simpan kasus yang True Negative
$FP = 0; // simpan kasus yang False Positive
$FN = 0; // simpan kasus yang False Negative


while($data = mysqli_fetch_array($select_data)) { // perulangan setiap record dari dataset
    // jumlahkan semua c1 dari atribut yang sesuai dengan dataset, dan data c1 diambil dari atribut yang di simpan di variabel probabilitas di perhitungan sebelumnya
    $total_c1 = $semua_probabilitas['usia'][$data['usia']]['c1'] * 
        $semua_probabilitas['gejala_miokard'][$data['gejala_miokard']]['c1'] *
        $semua_probabilitas['merokok'][$data['merokok']]['c1'] *
        $semua_probabilitas['diabetes'][$data['diabetes']]['c1'] *
        $semua_probabilitas['darah_tinggi'][$data['darah_tinggi']]['c1'] *
        $semua_probabilitas['kolesterol'][$data['kolesterol']]['c1'] *
        $semua_probabilitas['angina'][$data['angina']]['c1'] *
        $semua_probabilitas['stroke'][$data['stroke']]['c1'];
    // jumlahkan semua c2 dari atribut yang sesuai dengan dataset, dan data c2 diambil dari atribut yang di simpan di variabel probabilitas di perhitungan sebelumnya
    $total_c2 = $semua_probabilitas['usia'][$data['usia']]['c2'] * 
        $semua_probabilitas['gejala_miokard'][$data['gejala_miokard']]['c2'] *
        $semua_probabilitas['merokok'][$data['merokok']]['c2'] *
        $semua_probabilitas['diabetes'][$data['diabetes']]['c2'] *
        $semua_probabilitas['darah_tinggi'][$data['darah_tinggi']]['c2'] *
        $semua_probabilitas['kolesterol'][$data['kolesterol']]['c2'] *
        $semua_probabilitas['angina'][$data['angina']]['c2'] *
        $semua_probabilitas['stroke'][$data['stroke']]['c2'];
    // perbandingan dari total c1 dan c2 yang menentukan klasifikasi hidup dan meninggal
    $klasifikasi = $total_c1 > $total_c2 ? "Hidup" : "Meninggal";
    // menentukan record dataset dan hasil klasifikasi masuk kriteria yang mana
    if ($klasifikasi == "Hidup" && $data['outcome'] == "Hidup") {
        $kriteria = "TP";
        $TP = $TP + 1; // jika masuk kriteria ke True Positive maka variabel TP ditambah 1
    } elseif ($klasifikasi == "Hidup" && $data['outcome'] == "Meninggal") {
        $kriteria = "FN";
        $FN = $FN + 1; // jika masuk kriteria ke False Negative maka variabel FN ditambah 1
    } elseif ($klasifikasi == "Meninggal" && $data['outcome'] == "Hidup") {
        $kriteria = "FP";
        $FP = $FP + 1; // jika masuk kriteria ke False Positive maka variabel FP ditambah 1
    } elseif ($klasifikasi == "Meninggal" && $data['outcome'] == "Meninggal") {
        $kriteria = "TN";
        $TN = $TN + 1; // jika masuk kriteria ke True Negative maka variabel TN ditambah 1
    }
    // simpan hasil klasifikasi tadi ke tabel perhitungan
    mysqli_query($koneksi, "INSERT INTO `perhitungan_latih`(`id`, `usia_c1`, `usia_c2`, `gejala_miokard_c1`, `gejala_miokard_c2`, `merokok_c1`, `merokok_c2`, `diabetes_c1`, `diabetes_c2`, `darah_tinggi_c1`, `darah_tinggi_c2`, `kolesterol_tinggi_c1`, `kolesterol_tinggi_c2`, `angina_c1`, `angina_c2`, `stroke_c1`, `stroke_c2`, `total_c1`, `total_c2`, `klasifikasi`, `kriteria`) VALUES 
    (".$data['id'].",
    ".$semua_probabilitas['usia'][$data['usia']]['c1'].",
    ".$semua_probabilitas['usia'][$data['usia']]['c2'].",
    ".$semua_probabilitas['gejala_miokard'][$data['gejala_miokard']]['c1'].",
    ".$semua_probabilitas['gejala_miokard'][$data['gejala_miokard']]['c2'].",
    ".$semua_probabilitas['merokok'][$data['merokok']]['c1'].",
    ".$semua_probabilitas['merokok'][$data['merokok']]['c2'].",
    ".$semua_probabilitas['diabetes'][$data['diabetes']]['c1'].",
    ".$semua_probabilitas['diabetes'][$data['diabetes']]['c2'].",
    ".$semua_probabilitas['darah_tinggi'][$data['darah_tinggi']]['c1'].",
    ".$semua_probabilitas['darah_tinggi'][$data['darah_tinggi']]['c2'].",
    ".$semua_probabilitas['kolesterol'][$data['kolesterol']]['c1'].",
    ".$semua_probabilitas['kolesterol'][$data['kolesterol']]['c2'].",
    ".$semua_probabilitas['angina'][$data['angina']]['c1'].",
    ".$semua_probabilitas['angina'][$data['angina']]['c2'].",
    ".$semua_probabilitas['stroke'][$data['stroke']]['c1'].",
    ".$semua_probabilitas['stroke'][$data['stroke']]['c2'].",
    ".$total_c1.",".$total_c2.",'".$klasifikasi."','".$kriteria."')");
}

$akurasi = (($TP + $TN) / ($TP+$TN+$FP+$FN)) * 100; // hitung akurasi dari perhitungan sebelumnya
$presisi = ($TP / ($TP + $FP)) * 100; // hitung presisi dari perhitungan sebelumnya
$recall = ($TP / ($TP + $FN)) * 100; // hitung recall dari perhitungan sebelumnya
// hasil dari perhitungan akurasi, presisi, dan recall di simpan ke tabel hasil
mysqli_query($koneksi, "UPDATE `hasil` SET TP='$TP', TN='$TN', FP='$FP', FN='$FN', akurasi='$akurasi', presisi='$presisi', recall='$recall'");

?>
    <h1>Perhitungan Berhasil</h1>
<?php

include "footer.php";