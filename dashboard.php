<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Ambil data barang dari database
$result = $conn->query("SELECT * FROM tabel ORDER BY id DESC"); // Tambahkan ORDER BY untuk memastikan data terbaru muncul di atas
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Stok Barang</h3>
    
    <!-- Tambahkan menu Kasir -->
    <a href="kasir.php" class="btn btn-primary mb-3">Menu Kasir</a>
    
    <a href="tambah.php" class="btn btn-success mb-3">Tambah Barang</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['harga']}</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-secondary">Logout</a> <!-- Tombol untuk logout -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
