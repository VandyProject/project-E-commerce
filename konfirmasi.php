<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Jika tidak ada session pelanggan (belum login)
if(!isset($_SESSION['pelanggan']) OR empty($_SESSION['pelanggan'])){
	echo "<script>alert('Silahkan login');</script>";
	echo "<script>location='login.php';</script>";
	exit();
}

// Mendapatkan id_pembelian dari url
$idpem = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$idpem'");
$detpem = $ambil->fetch_assoc();

// echo "<pre>";
// print_r($detpem);
// print_r($_SESSION);
// echo "</pre>";

// Mendapatkan id_pelanggan yg beli
$id_pelanggan_beli = $detpem['id_pelanggan'];
// Mendapatkan id_pelanggan yg login
$id_pelanggan_login = $_SESSION['pelanggan']['id_pelanggan'];

if($id_pelanggan_beli != $id_pelanggan_login){
  echo "<script>alert('Akses ditolak!');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>konfirmasi barang diterima</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <h3>konfirmasi barang diterima</h3>
    <!-- <p>Kirim bukti pembayaran anda disini</p> -->
    <div class="row">
      <div class="col-md-10">
        <div class="">Tambahkan ulasan produk dan bukti foto produk telah diterima! <strong> </strong></div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="">ulasan produk</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <!-- <div class="form-group">
            <label for="">Bank</label>
            <input type="text" class="form-control" name="bank">
          </div>
          <div class="form-group">
            <label for="">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" min="1">
          </div> -->
          <div class="form-group">
            <label for="">Foto Bukti</label>
            <input type="file" class="form-control" name="bukti">
            <p class="text-danger">foto bukti harus JPG maksimal 2 MB</p>
          </div>
          <button class="btn btn-primary" name="kirim">Kirim</button>
        </form>

        <?php
        // Jika tombol kirim di pencet
        if(isset($_POST['kirim'])){
          // Upload dulu foto bukti
          $namabukti = $_FILES['bukti']['name'];
          $lokasibukti = $_FILES['bukti']['tmp_name'];
          $namafiks = date('YmdHis').$namabukti;
          move_uploaded_file($lokasibukti, "konfirmasi/$namafiks");

          $nama = $_POST['nama'];
          // $bank = $_POST['bank'];
          // $jumlah = $_POST['jumlah'];
          $tanggal = date('Y-m-d');

          // Insert ke tabel pembayaran
          // $result = $koneksi->query("INSERT INTO konfirmasi VALUES('', '$_POST[id_pembayaran]', '$_POST[nama]', '$_POST[tanggal]', '$_POST[namafiks]')");

          $koneksi->query("INSERT INTO konfirmasi(id_pembelian, nama, bank, jumlah, tanggal, bukti) VALUES('$idpem', '$nama', '$bank', '$jumlah', '$tanggal', '$namafiks')");

          // Update data pembelian dari pending menjadi sudah kirim pembayaran
          $koneksi->query("UPDATE pembelian SET status_pembelian='sudah konfirmasi barang diterima' WHERE id_pembelian='$idpem'");

          echo "<script>alert('Terima kasih sudah melakukan pkonfirmasi barang diterima');</script>";
	        echo "<script>location='riwayat.php';</script>";
        }
        ?>

      </div>
    </div>
  </div>
</section>
  
</body>
</html>