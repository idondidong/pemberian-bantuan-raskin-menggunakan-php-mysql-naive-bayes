<?php 
include "koneksi.php";
include "header.php";

$nama = $_SESSION['nama'];
$ktp = $_SESSION['user'];

$select_data = mysqli_query($koneksi, "select * from warga where kepala_rumah_tangga = '$nama' ");
$baris = mysqli_fetch_array($select_data);
$jumlah = mysqli_num_rows($select_data);
	

?>
<!-- kl -->
	<center>
		<h1>Data Diri</h1>
		<table class="table table-bordered">
			<tr>
				<td>Nama</td>
				<td><?= $baris['kepala_rumah_tangga']?></td>
			</tr>
			<tr>
				<td>NO KTP</td>
				<td><?php echo $ktp; ?></td>
			</tr>
			<tr>
				<td>luas rumah kurang dari 40m</td>
				<td><?= $baris['luas_rumah_kurang_dari_40m']?></td>
			</tr>
			<tr>
				<td>dinding rumah tembok tanpa plester</td>
				<td><?= $baris['dinding_rumah_tembok_tanpa_plester']?></td>
			</tr>
			<tr>
				<td>pekerjaan tenaga kasar atau tidak punya pekerjaan</td>
				<td><?= $baris['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan']?></td>
			</tr>
			<tr>
				<td>tabungan simpanan perbulan kurang dari satujuta</td>
				<td><?= $baris['tabungan_simpanan_perbulan_kurang_dari_satujuta']?></td>
			</tr>
			<tr>
				<td>jenis lantai rumah plester semen</td>
				<td><?= $baris['jenis_lantai_rumah_plester_semen']?></td>
			</tr>
			<tr>
				<td>tak punya jamban keluarga</td>
				<td><?= $baris['tak_punya_jamban_keluarga']?></td>
			</tr>
			<tr>
				<td>sumber air bersih sumur</td>
				<td><?= $baris['sumber_air_bersih_sumur']?></td>
			</tr>
			<?php 
			$select_klasifikasi = mysqli_query($koneksi, "select * from akhir where kepala_rumah_tangga = '$nama' ");
			$klasifikasi = mysqli_fetch_array($select_klasifikasi);
			 ?>
			<tr>
				<td>Perlu Bantuan Lebih</td>
				<td><button type="button" class="btn btn-primary"><?= $klasifikasi['klasifikasi']?></button></td>
			</tr>
			
		</table>
	</center>
<?php 
	include "footer.php";
 ?>
