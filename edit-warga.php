

<?php 
	include ("koneksi.php");

	$kepala_rumah_tangga = $_GET['kepala_rumah_tangga'];
?>

<form method="post">
<?php 
	$selectwarga =  "select * from warga where kepala_rumah_tangga = '$kepala_rumah_tangga'";
	$hasil = mysqli_query($koneksi, $selectwarga);
	$row = mysqli_fetch_array($hasil, MYSQLI_ASSOC);

	if (mysqli_num_rows($hasil) == 0) {
		echo "data kosong";
	} else {


 ?>
 <div class="container">
 	
 </div>
	<center><h3>Form Edit</h3>
	<table>
		<!-- <tr>
			<td>Id</td>
			<td>:</td>
			<td><input type="text" name="id" value="<?php echo $row['id']; ?>"></td>
		</tr> -->
		<tr>
			<td>Kepala rumah tangga</td>
			<td>:</td>
			<td><input type="text" name="kepala_rumah_tangga" class="form-control" value="<?php echo $row['kepala_rumah_tangga']; ?>" readonly></td>
		</tr>
		<tr>
			<td>luas_rumah_kurang_dari_40m</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="luas_rumah_kurang_dari_40m" value="<?php echo $row['luas_rumah_kurang_dari_40m']; ?>"></td>
		</tr>
		<tr>
			<td>dinding_rumah_tembok_tanpa_plester</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="dinding_rumah_tembok_tanpa_plester" value="<?php echo $row['dinding_rumah_tembok_tanpa_plester']; ?>"></td>
		</tr>
		<tr>
			<td>pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan" value="<?php echo $row['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan']; ?>"></td>
		</tr>
		<tr>
			<td>tabungan_simpanan_perbulan_kurang_dari_satujuta</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="tabungan_simpanan_perbulan_kurang_dari_satujuta" value="<?php echo $row['tabungan_simpanan_perbulan_kurang_dari_satujuta']; ?>"></td>
		</tr>
		<tr>
			<td>jenis_lantai_rumah_plester_semen</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="jenis_lantai_rumah_plester_semen" value="<?php echo $row['jenis_lantai_rumah_plester_semen']; ?>"></td>
		</tr>
		<tr>
			<td>tak_punya_jamban_keluarga</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="tak_punya_jamban_keluarga" value="<?php echo $row['tak_punya_jamban_keluarga']; ?>"></td>
		</tr>
		<tr>
			<td>sumber_air_bersih_sumur</td>
			<td>:</td>
			<td><input type="text" class="form-control" name="sumber_air_bersih_sumur" value="<?php echo $row['sumber_air_bersih_sumur']; ?>"></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
		<br>
			<td colspan=3 align="center"><a href="data-warga.php"> <button type="button" class="btn btn-danger">Kembali</button></a> &nbsp <input type="submit" name="submit" class="btn btn-primary" value="Simpan"></td>
		</tr>
	</table>
</form>

<?php 
}
	if (isset($_POST['submit'])) {
		$kepala_rumah_tangga = $_POST['kepala_rumah_tangga'];
		$luas_rumah_kurang_dari_40m = $_POST['luas_rumah_kurang_dari_40m'];
		$dinding_rumah_tembok_tanpa_plester = $_POST['dinding_rumah_tembok_tanpa_plester'];
		$pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan = $_POST['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan'];
		$tabungan_simpanan_perbulan_kurang_dari_satujuta = $_POST['tabungan_simpanan_perbulan_kurang_dari_satujuta'];
		$jenis_lantai_rumah_plester_semen = $_POST['jenis_lantai_rumah_plester_semen'];
		$tak_punya_jamban_keluarga = $_POST['tak_punya_jamban_keluarga'];
		$sumber_air_bersih_sumur = $_POST['sumber_air_bersih_sumur'];

		$editwarga = "update warga set  luas_rumah_kurang_dari_40m='$luas_rumah_kurang_dari_40m', dinding_rumah_tembok_tanpa_plester='$dinding_rumah_tembok_tanpa_plester', pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan='$pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan', tabungan_simpanan_perbulan_kurang_dari_satujuta='$tabungan_simpanan_perbulan_kurang_dari_satujuta', jenis_lantai_rumah_plester_semen='$jenis_lantai_rumah_plester_semen', tak_punya_jamban_keluarga='$tak_punya_jamban_keluarga', sumber_air_bersih_sumur='$sumber_air_bersih_sumur' where kepala_rumah_tangga='$kepala_rumah_tangga'";
		

		if (mysqli_query($koneksi, $editwarga)) {
			echo "Data Berhasil Diubah";
			header("Location: data-warga.php");
		} else {
			echo "error";
		}
	}
 ?>
 </center>

  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="main.css"/>
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>