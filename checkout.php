<?php
session_start();
include 'koneksi.php';

// Cek apakah ada barang dalam keranjang
if (!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0) {
    header("Location: kasir.php");
    exit;
}

// Menghitung total belanja
$total_belanja = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total_belanja += $item['total'];
}

// Proses Checkout
if (isset($_POST['proses_checkout'])) {
    // Ambil data pembeli (misalnya, nama pembeli)
    $nama_pembeli = $_POST['nama_pembeli'];

    // Simpan transaksi ke dalam database
    $query = "INSERT INTO transaksi (nama_pembeli, total_bayar) VALUES ('$nama_pembeli', $total_belanja)";
    if ($conn->query($query) === TRUE) {
        // Ambil ID transaksi yang baru saja disimpan
        $transaksi_id = $conn->insert_id;

        // Simpan detail transaksi (barang yang dibeli)
        foreach ($_SESSION['keranjang'] as $item) {
            $id_barang = $item['id_barang'];
            $jumlah_beli = $item['jumlah_beli'];
            $total_item = $item['total'];

            // Insert detail transaksi ke dalam tabel detail_transaksi
            $detail_query = "INSERT INTO detail_transaksi (transaksi_id, id_barang, jumlah_beli, total) 
                             VALUES ($transaksi_id, $id_barang, $jumlah_beli, $total_item)";
            $conn->query($detail_query);
        }

        // Hapus keranjang setelah transaksi berhasil
        unset($_SESSION['keranjang']);

        // Redirect langsung ke halaman dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Terjadi kesalahan dalam proses transaksi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Checkout</h3>
    <form method="POST" action="checkout.php">
        <div class="mb-3">
            <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
            <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" required>
        </div>

        <h4 class="mt-5">Ringkasan Belanja</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($_SESSION['keranjang'] as $item) {
                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$item['nama_barang']}</td>
                        <td>Rp. {$item['harga']}</td>
                        <td>{$item['jumlah_beli']}</td>
                        <td>Rp. {$item['total']}</td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>

        <div class="alert alert-info">
            <h5>Total Belanja: Rp. <?= number_format($total_belanja, 0, ',', '.') ?></h5>
        </div>

        <button type="submit" name="proses_checkout" class="btn btn-success">Proses Pembayaran</button>
    </form>
    <a href="kasir.php" class="btn btn-secondary">Kembali ke Kasir</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
