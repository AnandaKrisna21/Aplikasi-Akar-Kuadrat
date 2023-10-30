<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
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

        // SQL untuk menghapus log perhitungan
        $sql = "DELETE FROM AkarKuadrat WHERE ID = $id";

        if ($conn->query($sql) === TRUE) {
            header("refresh:0; url=view_per_pengguna.php");
        } else {
            echo 
            '<script>
                alert("Data tidak berhasil dihapus.");
            </script>';
        }

        $conn->close();
    }
?>