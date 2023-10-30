<?php
    session_start();
    if (!isset($_SESSION["NIM"])) {
        header("Location: login.php");
    }
    $userRole = $_SESSION["role"];

    $conn = new mysqli("localhost", "root", "", "sql_akar_kuadrat");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $currentPage = 1;
    $totalPages = 1;
    $sql = "SELECT * FROM AkarKuadrat ";
    $result = $conn->query($sql);
    if ($result !== null && $result->num_rows > 0) {
        $dataPerPage = 10;
        $totalPages = ceil($result->num_rows / $dataPerPage);
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $dataPerPage;
    
        $sql = "SELECT * FROM AkarKuadrat LIMIT $dataPerPage OFFSET $offset";
        $result = $conn->query($sql);
    } else {
        echo "Tidak ada hasil perhitungan.";
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
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
                <a href="index.php" onclick="loadPage('menu.php')">
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
        <title>Hitung Akar Kuadrat</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .pagination {
                justify-content: center;
                margin-top: 20px;
                margin-left: 130px;
            }
   
            #sortColumn,
            #sortOrder {
                width: 300px; 
                display: inline-block;
            }

            #userTable {
                width: 70%;
                margin: 0 auto;
                margin-right: 120px;
            }
 
            .container {
                margin-right: 190px;
            }

            .row {
                margin-top: 100px;
            }
        </style>
    </head>
    <body>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select id="sortColumn" class="form-control">
                        <option value="0">ID</option>
                        <option value="1">Username</option>
                        <option value="2">Angka</option>
                        <option value="3">Hasil</option>
                        <option value="4">Metode</option>
                        <option value="5">Waktu Komputasi</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <select id="sortOrder" class="form-control">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button class="btn btn-primary" id="refreshButton">
                        <i class="fas fa-redo"></i> Refresh Data
                    </button>
                </div>
            </div>
        </div>
        <table class="table" id="userTable">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Angka</th>
                <th scope="col">Hasil</th>
                <th scope="col">Metode</th>
                <th scope="col">Waktu Komputasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>".$row["ID"]."</td>
                            <td>".$row["username"]."</td>
                            <td>".$row["Angka"]."</td>
                            <td>".$row["Hasil"]."</td>
                            <td>".$row["Metode"]."</td>
                            <td>".$row["Waktu"]."</td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "Tidak ada hasil perhitungan.";
                    }
                
                    $conn->close();
                ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                    $maxPages = 10; // Maksimal jumlah nomor halaman yang ditampilkan
                    $halfMaxPages = floor($maxPages / 2);
                    $startPage = max(1, min($totalPages - $maxPages + 1, $currentPage - $halfMaxPages));
                    $endPage = min($totalPages, $startPage + $maxPages - 1);

                    if ($currentPage > 1) {
                        echo "<li class='page-item'><a class='page-link' href='view.php?page=1'>&laquo;&laquo;</a></li>"; // Tanda panah untuk ke halaman pertama
                        echo "<li class='page-item'><a class='page-link' href='view.php?page=" . ($currentPage - 1) . "'>&laquo;</a></li>"; // Tanda panah untuk halaman sebelumnya
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        echo "<li class='page-item " . ($i == $currentPage ? 'active' : '') . "'><a class='page-link' href='view.php?page=$i'>$i</a></li>";
                    }

                    if ($currentPage < $totalPages) {
                        echo "<li class='page-item'><a class='page-link' href='view.php?page=" . ($currentPage + 1) . "'>&raquo;</a></li>"; // Tanda panah untuk halaman berikutnya
                        echo "<li class='page-item'><a class='page-link' href='view.php?page=$totalPages'>&raquo;&raquo;</a></li>"; // Tanda panah untuk ke halaman terakhir
                    }
                ?>
            </ul>
        </nav>
        <script>
            var sortColumnDropdown = document.getElementById("sortColumn");
            var sortOrderDropdown = document.getElementById("sortOrder");
            var userTable = document.getElementById("userTable");

            sortColumnDropdown.addEventListener("change", sortTable);
            sortOrderDropdown.addEventListener("change", sortTable);

            function sortTable() {
                var columnIndex = sortColumnDropdown.value;
                var order = sortOrderDropdown.value;
                var rows, switching, i, x, y, shouldSwitch, switchcount = 0;
                switching = true;

                while (switching) {
                    switching = false;
                    rows = userTable.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;

                        x = rows[i].getElementsByTagName("td")[columnIndex];
                        y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                        if (order === "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (order === "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    }
                }
            }
        </script>
        <script>
            var refreshButton = document.getElementById("refreshButton");
            refreshButton.addEventListener("click", function() {
                console.log("Data refreshed!"); // Contoh: Log pesan refresh ke konsol
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>