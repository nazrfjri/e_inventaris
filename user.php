<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-j5HkvhFIhCjo1HqzEPl+MhviqKCj6G9zxfYTV7BpM0XkDmW0TTsQxMvblp0EJw2Ndxag4VwfKOuXWDL5a13yNQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-image: url('img/inv8.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.5);
        }
        .nav-link:hover {
            color: #fff;
        }
        .navbar-nav {
        align-items: center;
        }
        .user-icon {
            font-size: 20px;
            margin-right: 5px;
        }
        .logout-btn {
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
        }
        .logout-btn:hover {
            color: #fff;
        }
        .card {
            margin-top: 50px;
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #333;
            color: #fff;
        }
        .table {
            margin-bottom: 0;
        }
        .table th, .table td {
            vertical-align: middle;
            border-color: #dee2e6;
        }
    </style>
    <title>Data Pengguna</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #333;">
        <div class="container">
            <a class="navbar-brand" href="#" id="navbarBrand" style="color: white;">&#9776;</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-text text-light">
                <?php echo "Selamat datang, " . $_SESSION['username']; ?>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-user user-icon"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card rounded shadow">
            <div class="card-header">
                <h2>Data Pengguna</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>Nama:</th>
                                <td><?php echo $row['nama']; ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo $row['email']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            var confirmLogout = confirm("Apakah yakin ingin logout?");
            if (confirmLogout) {
                alert("Anda telah logout");
                window.location.href = 'index.php';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
