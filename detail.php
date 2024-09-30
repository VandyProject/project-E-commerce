<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Mendapatkan id_produk dari url
$id_produk = $_GET['id'];

// Query ambil data
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();

// echo "<pre>";
// print_r($detail);
// echo "</pre>";

// Jika tombol beli di klik
if(isset($_POST['beli'])){
  // Mendapatkan jumlah yang diinputkan
  $jumlah = $_POST['jumlah'];

  // Masukkan ke keranjang belanja
  $_SESSION['keranjang'][$id_produk] = $jumlah;

  echo "<div class='alert alert-success'>Produk telah masuk ke keranjang</div>";
  echo "<meta http-equiv='refresh' content='1;url=keranjang.php'>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<!-- navbar -->
<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="foto_produk/<?= $detail['foto_produk']; ?>" class="img-responsive">
      </div>
      <div class="col-md-6">
        <h2><?= $detail['nama_produk']; ?></h2>
        <h4>Rp. <?= number_format($detail['harga_produk']); ?>,-</h4>
        <h5>Stok : <?= $detail['stok_produk']; ?></h5>
        <form action="" method="post">
          <div class="form-group">
            <div class="input-group">
              <input type="number" min="1" max="<?= $detail['stok_produk']; ?>" class="form-control" name="jumlah">
              <div class="input-group-btn">
                <button class="btn btn-primary" name="beli">beli</button>
              </div>
            </div>
          </div>
        </form>

        <p><?= $detail['deskripsi_produk']; ?></p>
      </div>
       
</body>
</html>
<title>ulasan pelanggan</title>
<!-- <h2><h1>ulasan pelanggan</h2></h1> -->

<?php
// Mendapatkan id_pembelian dari url
$id_pembelian = $_GET['id'];

// Mengambil data pembayaran berdasarkan id_pembelian
$ambil = $koneksi->query("SELECT * FROM konfirmasi WHERE id_pembelian='$id_pembelian'");
$detail = $ambil->fetch_assoc();

?>


<div class="row">
  <div class="col-md-6">
    <table class="table">
      <tr>
        <th>ulasan produk</th>
        <td><?= $detail['nama']; ?></td>
      </tr>
      <!-- <tr>
        <th>Bank</th>
        <td><?= $detail['bank']; ?></td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>Rp. <?= number_format($detail['jumlah']); ?>,-</td>
      </tr>
      <tr> -->
        <th>sangat baik</th>
        <td><?= $detail['tanggal']; ?></td>
      </tr>
    </table>
  </div>
  <div class="col-md-6">
    <img src="admin/konfirmasi/<?= $detail['bukti']; ?>" alt="" class="img-responsive">
  </div>
</div>

    </div>
  </div>
</section>
 
<!-- <div class="row">
  <div class="col-md-6">
    <form action="" method="post">
      <div class="form-group">
        <Label>No Resi Pengiriman</Label>
        <input type="text" class="form-control" name="resi">
      </div>
      <div class="form-group">
        <label for="">Status</label>
        <select name="status" id="" class="form-control">
          <option value="">Pilih Status</option>
          <option value="lunas">Lunas</option>
          <option value="dikemas">Dikemas</option>
          <option value="barang dikirim">Barang Dikirim</option>
          <option value="batal">Batal</option>
        </select>
      </div>
      <button class="btn btn-success" name="proses">Proses</button>
    </form>
  </div>
</div> -->

<?php
if(isset($_POST['proses'])){
  $resi = $_POST['resi'];
  $status = $_POST['status'];
  $koneksi->query("UPDATE pembelian SET resi_pengiriman='$resi', status_pembelian='$status' WHERE id_pembelian='$id_pembelian'");

  echo "<script>alert('Data pembelian terupdate');</script>";
  echo "<script>location='index.php?halaman=pembelian';</script>";
}

?>