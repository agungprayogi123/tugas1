<?php
session_start();
session_destroy(); // Menghancurkan sesi pengguna
header("Location: index.php"); // Redirect ke halaman login
exit;
?>
