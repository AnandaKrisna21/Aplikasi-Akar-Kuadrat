<?php
session_start();

// Hapus semua data sesi
session_destroy();

// Alihkan pengguna ke halaman login atau halaman lain yang sesuai
echo "<script> alert('Logout Berhasil');</script>";
header("refresh:0; url=login.php");

?>
