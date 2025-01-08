<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda benar

// Ambil input dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Enkripsi password dengan password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan pengguna
$sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    echo "Pengguna berhasil ditambahkan!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<!-- Form untuk input pengguna baru -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Tambah Pengguna</h3>
    <form method="POST" action="tambah_user.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
    </form>
</div>
</body>
</html>
