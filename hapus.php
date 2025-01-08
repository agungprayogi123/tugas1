<?php
include 'koneksi.php';

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $result = $conn->query("DELETE FROM tabel WHERE id = $id");

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='dashboard.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='dashboard.php';</script>";
}
?>
