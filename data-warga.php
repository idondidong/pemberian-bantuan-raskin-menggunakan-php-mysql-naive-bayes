<?php 
include "koneksi.php";
include "header.php";


// $select_data = mysqli_query($koneksi, "select id, 
// 										kepala_rumah_tangga from warga, 
// 										luas_rumah_kurang_dari_40m,
// 										dinding_rumah_tembok_tanpa_plester,
// 										pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan,
// 										tabungan_simpanan_perbulan_kurang_dari_satujuta,
// 										jenis_lantai_rumah_plester_semen,
// 										tak_punya_jamban_keluarga,
// 										sumber_air_bersih_sumur,
// 										username

// 										from 
// 										warga, pengguna where pengguna.nama = warga.kepala_rumah_tangga");

$select_data = mysqli_query($koneksi, "select username, 
											kepala_rumah_tangga, 
											luas_rumah_kurang_dari_40m,
											dinding_rumah_tembok_tanpa_plester,
											pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan,
											tabungan_simpanan_perbulan_kurang_dari_satujuta,
											jenis_lantai_rumah_plester_semen,
											tak_punya_jamban_keluarga,
											sumber_air_bersih_sumur,
											tanggal_survei
											from warga, pengguna where pengguna.nama = warga.kepala_rumah_tangga");
// $baris = mysqli_fetch_array($select_data);
// $jumlah = mysqli_num_rows($select_data);
	

?>
<!-- kl -->
<center>
	<table class="table table-striped table-hover">
	<thead>
		<th>No. KTP</th>
		<th>Nama</th>
		<th>luas rumah kurang dari 40m</th>
		<th>dinding rumah tembok tanpa plester</th>
		<th>pekerjaan tenaga kasar atau tidak punya pekerjaan</th>
		<th>tabungan simpanan perbulan kurang dari satujuta</th>
		<th>jenis lantai rumah plester semen</th>
		<th>tak punya jamban keluarga</th>
		<th>sumber air bersih sumur</th>
		<th>Tanggal survei</th>
		<!-- <th>Edit</th> -->
		<th>Hapus</th>
</thead>
		
		
		<?php 
			while ($data = mysqli_fetch_array($select_data)): 

		 ?>
		 	<tr>
			
            <td><?= $data['username']; ?></td>
            <td><?= $data['kepala_rumah_tangga']; ?></td>
            <td><?= $data['luas_rumah_kurang_dari_40m']; ?></td>
            <td><?= $data['dinding_rumah_tembok_tanpa_plester']; ?></td>
            <td><?= $data['pekerjaan_tenaga_kasar_atau_tidak_punya_pekerjaan']; ?></td>
            <td><?= $data['tabungan_simpanan_perbulan_kurang_dari_satujuta']; ?></td>
            <td><?= $data['jenis_lantai_rumah_plester_semen']; ?></td>
            <td><?= $data['tak_punya_jamban_keluarga']; ?></td>
            <td><?= $data['sumber_air_bersih_sumur']; ?></td>
            <td><?= $data['tanggal_survei']; ?></td>
            <!-- <?php echo "<td><a href='edit-warga.php?kepala_rumah_tangga=$data[kepala_rumah_tangga]'><button type='button' class='btn btn-success btn-sm'>Edit</button></a></td>"; ?> -->
            <?php echo "<td><a href='hapus-warga.php?kepala_rumah_tangga=$data[kepala_rumah_tangga]'><button type='button' class='btn btn-danger btn-sm'>Hapus</button></a></td>"; ?>
            

		</tr>
		<?php 
			endwhile;
		 ?>
	</table>

<!-- </center>
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
			<tr>
				<td>Perlu Bantuan Lebih</td>
				<td><button type="button" class="btn btn-primary"><?= $baris['perlu_bantuan_lebih']?></button></td>
			</tr>
			
		</table>
	</center> -->
<?php 
	include "footer.php";
 ?>
