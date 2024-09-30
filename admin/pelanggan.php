<h2>Data Pelanggan</h2>

<table class="table table-bordered">
	<thead>
		<tr>
		<th>No</th>
		<th>Nama </th>
		<th>Email</th>
		<th>No Telepon</th>
		<th>aksi</th>
		</tr> 
	</thead>
	<tbody>

		<?php $no=1; ?>
		<?php $ambil = $koneksi->query("SELECT * FROM pelanggan"); ?>
		<?php while($pecah = $ambil->fetch_assoc()): ?>
		<tr>
			<td><?= $no; ?></td>
			<td><?= $pecah["nama_pelanggan"]; ?></td>
			<td><?= $pecah["email_pelanggan"]; ?></td>
			<td><?= $pecah["telepon_pelanggan"]; ?></td>
			<td>
				<a href="index.php?halaman=hapuspelanggan&id=<?= $pecah['id_pelanggan']; ?>" class="btn btn-danger btn-xs">Hapus</a>
			</td>
		</tr>
		<?php $no++; ?>
		<?php endwhile; ?>

	</tbody>
</table>