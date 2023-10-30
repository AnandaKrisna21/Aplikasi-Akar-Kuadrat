<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .register-container {
          background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="register-container">
                    <h2 class="text-center mb-4">Register</h2>
                    <form method="post" action="register.php">
                        <div class="form-group">
                            <label for="registerNIM">NIM:</label>
                            <input type="NIM" class="form-control" name="registerNIM" required>
                        </div>
                        <div class="form-group">
                            <label for="registerNama">Nama:</label>
                            <input type="text" class="form-control" name="registerNama" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Password:</label>
                            <input type="password" class="form-control" name="registerPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <p class="text-center mt-3">Already an account? <a href="login.php">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Koneksi ke database (gantilah sesuai pengaturan Anda)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "sql_akar_kuadrat";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Mengambil data dari formulir pendaftaran
        $nim = $_POST["registerNIM"];
        $nama = $_POST["registerNama"];
        $password = $_POST["registerPassword"];

        // Simpan data ke database
        $sql = "INSERT INTO users (nim, nama, password) VALUES ('$nim', '$nama', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script> alert('Pendaftaran Berhasil');</script>";
            header("refresh:0; url=login.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
  ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>    
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
