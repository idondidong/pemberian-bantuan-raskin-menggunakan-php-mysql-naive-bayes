<?php
include "koneksi.php";
include "header.php";


?>

<h1>Aturan</h1>
<table class="table">
	<thead>
		<th>Batas Kategori</th>
		<th>Kategori Taraf</th>
		<th>Penentuan Pemberi bantuan lebih</th>
	</thead>

	<tbody>
		<tr>
			<td>Jika jumlah indikator ya berjumlah 1-3 maka batas kategori "kurang dari 5"</td>
			<td>Apabila terdapat jumlah 1-3 indikator ya dari nomor 1,2,3,4,5,6 dan 7 maka masuk kategori "rentan miskin"</td>
			<td>Jika jumlah indikator tercentang 5-7 maka perlu diberi bantuan lebih</td>
		</tr>
		<tr>
			<td>Jika jumlah indikator ya berjumlah 4-5 maka batas kategori "sama dengan 5"</td>
			<td>Apabila terdapat jumlah 1-3 indikator ya dari nomor 1,2,3,4,5,6 dan 7 dan indikator no 4 bernyatakan tidak maka masuk kategori "rentan miskin"</td>
			<td>Jika terkategori fakir miskin maka perlu diberi bantuan lebih</td>
		</tr>
		<tr>
			<td>Jika jumlah indikator ya berjumlah 6-7 maka batas kategori "lebih dari 5"</td>
			<td>Apabila terdapat jumlah 4-5 indikator ya dari 7 indikator maka masuk dalam kategori "miskin"</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Apabila jumlah 6-7 indikator ya dan indikator no. 4 bernyatakan tidak, maka masuk dalam "rentan miskin</td>
			<td></td>
			
		</tr>
		<tr>
			<td></td>
			<td>Apabila jumlah 6-7 indikator ya maka masuk dalam "fakir miskin"</td>
			<td></td>
		</tr>
	</tbody>
</table>

<?php
include "footer.php";
?>