<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Lakukan koneksi ke database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "sql_akar_kuadrat";


        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $NIM = $_SESSION["NIM"];
        $sql = "DELETE FROM AkarKuadrat WHERE username = '$NIM'";

        if ($conn->query($sql) === TRUE) {
             echo 
            '<script>
                alert("Berhasil Menghapus Seluruh Data.");
            </script>';
    
        } else {
            echo 
            '<script>
                alert("Seluruh Data Tidak Berhasil disimpan");
            </script>';
        }
        header("refresh:0; url=view_per_pengguna.php");
    
        $conn->close();
    }
?>