<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ID'])) {
        $id = $_GET['ID'];

        // Lakukan koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "sql_akar_kuadrat";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Tampilkan konfirmasi pengguna
        echo "<script>
                var confirmation = confirm('Apakah Anda yakin ingin menghapus data?');
                if (confirmation) {
                    window.location.href = 'delete_per_pengguna.php?ID=$id';
                } else {
                    window.location.href = 'view_per_pengguna.php';
                }
            </script>";
        
        $conn->close();
    }

?>
