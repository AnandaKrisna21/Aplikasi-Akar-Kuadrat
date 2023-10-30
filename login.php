<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .login-container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<body>
<div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="login-container">
                    <h2 class="text-center mb-4">Login</h2>
                    <form method="POST" action="login.php">
                        <div class="form-group">
                            <label for="nim">NIM:</label>
                            <input type="nim" class="form-control" name="nim" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    session_start();
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

        // Mengambil data dari formulir login
        $nim = $_POST["nim"];
        $password = $_POST["password"];

        // Query untuk memeriksa kecocokan data
        $sql = "SELECT * FROM users WHERE nim='$nim' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row["role"];
            $_SESSION["NIM"] = $nim;
            $_SESSION["role"] = $role;
            echo "<script> alert('Login Berhasil');</script>";
            header("refresh:0; url=index.php");

        } else {
            // Login gagal
            echo "<script> alert('Login Tidak Berhasil');</script>";
        }

        $conn->close();
    }
?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
