<?php
session_start();
if (!isset($_SESSION["NIM"])) {
    // Redirect pengguna yang belum login ke halaman login
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="style_nav.css">
	<style>
		.logout-container {
			margin-top: 300px;
		}
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .welcome-text {
            font-size: 18px;
        }

        .nim-text {
            font-size: 18px;
        }
    </style>
</head>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">KuadratKu</span>
		</a>
		<?php
            $NIM = $_SESSION["NIM"];
        ?>
        <div class="user-info ml-auto mr-auto mt-3">
            <div class="user-icon">
                <i class='bx bx-user-circle display-1'></i>
            </div>
            <div>
                <div class="welcome-text">
                    Selamat Datang,
                </div>
                <div class="nim-text">
                    <?php echo $NIM; ?>
                </div>
            </div>
        </div>
		<ul class="side-menu top">
			<li class="active">
				<a href="">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
                <a href="index.php" onclick="loadPage('index.php')">
                    <i class='bx bxs-calculator' style="margin-right: 10px;"></i>
                    <span class="text">Hitung</span>
                </a>
            </li>
            <li>
                <a href="view_per_pengguna.php">
                    <i class='bx bxs-book' style="margin-right: 10px;"></i>
                    <span class="text">Rekap Per User</span>
                </a>
            </li>
            <li>
                <a href="view.php">
                    <i class='bx bxs-book' style="margin-right: 10px;"></i>
                    <span class="text">Rekap Keseluruhan</span>
                </a>
            </li>
		</ul>
		<div class="logout-container">
			<ul class="side-menu">
				<li>
					<a href="logout.php" class="logout">
						<i class='bx bxs-log-out-circle' ></i>
						<span class="text">Log Out</span>
					</a>
				</li>
			</ul>
		</div>
	</section>
	<!-- SIDEBAR -->
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator Akar Kuadrat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.result {
			margin-top: 80px;
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 10px;
			background-color: #add8e6; /* Warna biru muda */
		}

		body {
			margin-top: -70px;
			margin-left: 200px;
		}
    </style>
</head>
<body>
    <form class="custom-container" align="center" action="" method="post">
        <div class="kata" align="center">
            <label for="bilangan">Kalkulator Akar Kuadrat</label>
        </div>
        <div class="box" align="center">
            <input type="text" name="angka" value="<?php echo isset($_POST['angka']) ? $_POST['angka'] : ''; ?>" required>
        </div>
        <div>
            <button style="font-size: 15px;" class="sql" type="submit" name="hitung">Hitung SQL</button>
            <button style="font-size: 15px;" class="api" type="submit" name="api">Hitung API</button>
        </div>
		<div class="result">
			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hitung"])) {
					$angka = $_POST['angka'];
					$computationTime = null;
					$AkarKuadrat = null;
					$regex = '/^[0-9]+(\.[0-9]+)?$/';
					
					if(preg_match($regex, $angka)){
						$servername = "localhost";
						$username = "root";
						$password = "";
						$database = "sql_akar_kuadrat";

						$conn = new mysqli($servername, $username, $password, $database);

						if ($conn->connect_error) {
			?>
			<div class="alert alert-danger mt-4">
                <strong>Error!</strong> Koneksi ke database gagal. Silakan coba lagi.
            </div>
			<?php
				} else {
					$NIM = $_SESSION["NIM"];
					// Panggil stored procedure dan ambil hasilnya
					$sql = "CALL HitungAkarKuadrat($angka,'$NIM', @computation_time)";
					$conn->query($sql);

					// Menjalankan mysqli_next_result() untuk membersihkan hasil query sebelumnya
					while ($conn->more_results()) {
						$conn->next_result();
						$conn->use_result();
					}

					// Mengambil hasil dari variabel sesi MySQL
					$sql = "SELECT @computation_time as computation_time";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
                    $computationTime = $row['computation_time'];

					// Mengambil hasil dari variabel sesi MySQL untuk AkarKuadrat
					$sql = "SELECT SQRT('$angka') as AkarKuadrat";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					$AkarKuadrat = $row['AkarKuadrat'];

					$conn->close();
			?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Hasil Akar Kuadrat</th>
                        <th>Waktu Komputasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo number_format($AkarKuadrat, 6); ?></td>
                        <td><?php echo number_format($computationTime, 6); ?> detik</td>
                    </tr>
                </tbody>
            </table>
			<?php
				}
					} else {
			?>
			<div class="alert alert-danger mt-4">
                <strong>Error!</strong> Input tidak valid, harus angka dan bilangan bulat.
            </div>
			<?php
					}
				}
			?>


			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["api"])) {
					$servername = "localhost";
					$username = "root";
					$password = "";
					$database = "sql_akar_kuadrat";

					$conn = new mysqli($servername, $username, $password, $database);

					$angka = $_POST['angka'];
					$regex = '/^[0-9]+(\.[0-9]+)?$/';

					if(preg_match($regex, $angka)){
						$tebakan = $angka / 2;

						$startTime = microtime(true);
						while (abs($tebakan * $tebakan - $angka) > 0.0001) {
							$tebakan = ($tebakan + $angka / $tebakan) / 2;
						}
						$endTime = microtime(true);
						$computationTime = $endTime - $startTime;

						$NIM = $_SESSION["NIM"];
						$sql = "INSERT INTO AkarKuadrat (username, Angka, Hasil, Metode, Waktu) VALUES ('$NIM', '$angka', '$tebakan', 'API', '$computationTime')";
						if ($conn->query($sql) === TRUE) {
			?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Hasil Akar Kuadrat</th>
                        <th>Waktu Komputasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo number_format($tebakan, 6); ?></td>
                        <td><?php echo number_format($computationTime, 6); ?> detik</td>
                    </tr>
                </tbody>
            </table>
			<?php
				} else {
			?>
			<div class="alert alert-danger mt-4">
                <strong>Error!</strong> Input tidak valid, harus angka dan bilangan bulat.
            </div>
			<?php
				}					
				$conn->close();

				} else {
			?>
			<div class="alert alert-danger mt-4">
                <strong>Error!</strong> Input tidak valid, harus angka dan bilangan bulat.
            </div>
			<?php
				}
			}
			?>
		</div>
    </form>
</body>
</html>
