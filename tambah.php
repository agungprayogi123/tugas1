<?php
include 'koneksi.php'; // Sesuaikan dengan koneksi database Anda

if (isset($_POST['submit'])){
    // Ambil input dari form
$nama_barang = $_POST['nama_barang'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];

// Query untuk memasukkan barang
$sql = "INSERT INTO tabel (nama_barang, jumlah, harga) VALUES ('$nama_barang', '$jumlah', '$harga')";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php"); // Redirect kembali ke dashboard setelah menambah barang
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Tambah Barang</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button name="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
