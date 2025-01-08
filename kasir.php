<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Ambil data barang dari database
$result = $conn->query("SELECT * FROM tabel ORDER BY id DESC");

// Menangani proses tambah item ke dalam keranjang
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah_beli = $_POST['jumlah_beli'];

    // Ambil data barang berdasarkan ID
    $query = "SELECT * FROM tabel WHERE id = $id_barang";
    $result_barang = $conn->query($query);
    $barang = $result_barang->fetch_assoc();

    if ($barang) {
        $nama_barang = $barang['nama_barang'];
        $harga = $barang['harga'];
        $stok = $barang['jumlah'];

        // Cek apakah stok mencukupi
        if ($stok >= $jumlah_beli) {
            $total_item = $harga * $jumlah_beli;

            // Mengurangi stok barang
            $stok_baru = $stok - $jumlah_beli;
            $update_query = "UPDATE tabel SET jumlah = $stok_baru WHERE id = $id_barang";
            $conn->query($update_query);

            // Menyimpan item ke dalam session
            if (!isset($_SESSION['keranjang'])) {
                $_SESSION['keranjang'] = [];
            }
            $_SESSION['keranjang'][] = [
                'id_barang' => $id_barang,
                'nama_barang' => $nama_barang,
                'harga' => $harga,
                'jumlah_beli' => $jumlah_beli,
                'total' => $total_item
            ];
        } else {
            $error_message = "Stok tidak mencukupi. Stok tersedia: $stok";
        }
    } else {
        $error_message = "Barang tidak ditemukan.";
    }
}

// Menghitung total belanja
$total_belanja = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $total_belanja += $item['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Proses Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Proses Kasir</h3>

    <!-- Form Transaksi -->
    <form method="POST" action="kasir.php">
        <div class="mb-3">
            <label for="id_barang" class="form-label">Pilih Barang</label>
            <select name="id_barang" id="id_barang" class="form-select" required>
                <option value="">Pilih Barang</option>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['id']; ?>"><?= $row['nama_barang']; ?> (Stok: <?= $row['jumlah']; ?>)</option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah_beli" class="form-label">Jumlah Beli</label>
            <input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control" min="1" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Tambah ke Keranjang</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>

    <!-- Menampilkan error jika ada -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger mt-4"><?= $error_message ?></div>
    <?php endif; ?>

    <!-- Menampilkan List Belanjaan -->
    <h4 class="mt-5">List Belanjaan</h4>
    <?php if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0): ?>
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

        <!-- Total Belanja -->
        <div class="alert alert-info">
            <h5>Total Belanja: Rp. <?= number_format($total_belanja, 0, ',', '.') ?></h5>
        </div>

        <!-- Tombol untuk proses checkout -->
        <a href="checkout.php" class="btn btn-success">Checkout</a>
    <?php else: ?>
        <div class="alert alert-warning">
            Belum ada barang yang ditambahkan ke keranjang.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
