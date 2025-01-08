<?php
include 'koneksi.php';

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM tabel WHERE id = $id");

    // Cek apakah data ditemukan
    if ($result->num_rows == 1) {
        $barang = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";
        exit;
    }
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    // Update data barang
    $conn->query("UPDATE barang SET nama_barang = '$nama_barang', jumlah = '$jumlah', harga = '$harga' WHERE id = $id");

    // Redirect ke dashboard
    echo "<script>alert('Data berhasil diupdate!'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Edit Barang</h3>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $barang['id']; ?>">
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= $barang['nama_barang']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $barang['jumlah']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $barang['harga']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
