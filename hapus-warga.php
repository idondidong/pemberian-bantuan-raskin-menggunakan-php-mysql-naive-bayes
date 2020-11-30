

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
	<center><h3>Anda ingin menghapus data ini?</h3>
	<table>
		<!-- <tr>
			<td>Id</td>
			<td>:</td>
			<td><input type="text" name="id" value="<?php echo $row['id']; ?>"></td>
		</tr> -->
		<tr>
			<td>Kepala rumah tangga</td>
			<td>:</td>
			<td><input type="text" name="kepala_rumah_tangga" value="<?php echo $row['kepala_rumah_tangga']; ?>" disabled></td>
		</tr>
		<br>
		<tr>
		<br>
			<td colspan=3 align="center"><a href="data-warga.php"> <button type="button" class="btn btn-danger">Kembali</button></a> &nbsp <input type="submit" name="submit" class="btn btn-primary" value="Hapus"></td>
		</tr>
	</table>
</form>

<?php 
}
	if (isset($_POST['submit'])) {
		

		$editwarga = "delete from warga where kepala_rumah_tangga='$kepala_rumah_tangga'";
		$editpengguna = "delete from pengguna where nama = '$kepala_rumah_tangga'";

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