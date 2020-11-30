<?php 
	include "koneksi.php";
	require ('fpdf.php');

	$fpdf = new FPDF ('l','mm','A3');
	$fpdf->AddPage();
	$fpdf->SetFont('Arial','B',16);
	$fpdf->Cell(320,7,'DESA SUKORENO - JEMBER',0,1,'C');
	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(320,7,'DAFTAR WARGA PENERIMA BANTUAN',0,1,'C');
	$fpdf->Cell(10,7,'',0,1);

	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(10,10,'No ',1,0);
	$fpdf->Cell(35,10,'Nama ',1,0);
	$fpdf->Cell(35,10,'L rumah < 40m',1,0);
	$fpdf->Cell(48,10,'dinding tanpa_plester',1,0);
	$fpdf->Cell(35,10,'PTK/ tidak kerja',1,0);
	$fpdf->Cell(43,10,'tabungan/bulan < 1jt',1,0);
	$fpdf->Cell(45,10,'lantai plester semen',1,0);
	$fpdf->Cell(30,10,'tdk punya wc',1,0);
	$fpdf->Cell(30,10,'punya sumur',1,0);
	$fpdf->Cell(30,10,'tanggal survei',1,0);
	$fpdf->Cell(30,10,'Klasifikasi',1,1);

	$warga = mysqli_query($koneksi, "select * from warga,akhir where warga.kepala_rumah_tangga = akhir.kepala_rumah_tangga");
	while ($row = mysqli_fetch_array($warga)){
    $fpdf->Cell(10,6,$row['id'],1,0);
    $fpdf->Cell(35,6,$row['kepala_rumah_tangga'],1,0);
    $fpdf->Cell(35,6,$row['luas_rumah_kurang_dari_40m'],1,0);
    $fpdf->Cell(48,6,$row['dinding_rumah_tembok_tanpa_plester'],1,0);
    $fpdf->Cell(35,6,$row['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan'],1,0); 
    $fpdf->Cell(43,6,$row['tabungan_simpanan_perbulan_kurang_dari_satujuta'],1,0);
    $fpdf->Cell(45,6,$row['jenis_lantai_rumah_plester_semen'],1,0); 
    $fpdf->Cell(30,6,$row['tak_punya_jamban_keluarga'],1,0); 
    $fpdf->Cell(30,6,$row['sumber_air_bersih_sumur'],1,0);
    $fpdf->Cell(30,6,$row['tanggal_survei'],1,0);
    $fpdf->Cell(30,6,$row['klasifikasi'],1,1);


    


}
	$tanggal = date('d-m-Y');
	$fpdf->Cell(10,10,'',0,1);
	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(120,7,"Sukoreno, " .$tanggal,0,1,'1');
	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(120,7,'Mengetahui,',0,1,'l');
	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(120,7,'Kepala Desa Sukoreno,',0,1,'l');
	$fpdf->Cell(10,20,'',0,1);

	$fpdf->SetFont('Arial','B',12);
	$fpdf->Cell(120,7,'H. Yazid,',0,1,'l');

	$fpdf->Output();  
 ?> 