<?php
include 'koneksi.php';

$limit = 4;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

if (isset($_POST['bcari'])) {
    $keyword = $_POST['tcari'];
    $show = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR asal LIKE '%$keyword%' ORDER BY id_barang ASC");
} else {
    $show = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang ASC LIMIT $start, $limit");
}

$totalRecords = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
$totalPages = ceil($totalRecords / $limit);
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
    <title>Dashboard</title>
    <style>
        body {
            background-image: url('img/inv8.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background-color: #333;
            color: #fff;
            overflow-y: auto;
            width: 180px;
            transition: left 0.3s ease-out;
        }
        .sidebar.hide {
        transform: translateX(-180px);
        }
        .sidebar-open {
            left: 0;
        }
        .sidebar-closed {
            left: -180px;
        }
        .page-transition {
            opacity: 0;
            transform: translateX(180px);
            transition: opacity 0.3s, transform 0.3s;
        }
        .page-transition.show {
            opacity: 1;
            transform: translateX(0);
        }
        .sidebar-heading {
            text-align: center;
            padding: 0.875rem 0;
            font-size: 1.2rem;
            letter-spacing: 2px;
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
        .active-link {
            color: #fff !important;
            font-weight: bold;
        }
        .navbar .nav-item:last-child .nav-link {
            margin-right: 0;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #333;">
        <div class="container">
        <a class="navbar-brand" href="#" id="navbarBrand" style="color: white;">&#9776;</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user.php"><i class="fas fa-user user-icon"></i>Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" onclick="logout()"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar" id="sidebar">
            <h4 class="sidebar-heading">E-Inventaris</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active-link" aria-current="page" href="dashboard.php">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="input.php">Tambah Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard-edit.php">Pengaturan</a>
                </li>
            </ul>
        </div>

    <div class="container-fluid">
        <div class="card mt-3 mx-auto" style="max-width: 1000px;">
            <div class="card-header text-light text-center" style="background-color: #333;">
                Data Barang
            </div>
            <div class="card-body">
                <div class="col-md-6 mx-auto">
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="text" name="tcari" class="form-control" placeholder="Masukkan Kata Kunci!">
                            <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                            <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                        </div>
                    </form>
                </div>
                <p class="text-muted">Menampilkan halaman <?= $page ?> dari <?= $totalRecords ?> records</p>
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Asal Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Diterima</th>
                        <th>Gambar</th>
                    </tr>
                    <?php
                    $no = $start + 1;
                    while ($data = mysqli_fetch_array($show)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['kode'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['asal'] ?></td>
                            <td><?= $data['jumlah'] ?> <?= $data['satuan'] ?></td>
                            <td><?= $data['tanggal_diterima'] ?></td>
                            <td>
                                <?php if (!empty($data['gambar'])) : ?>
                                    <img src="img/<?= $data['gambar'] ?>" alt="Gambar Barang" width="100">
                                <?php else : ?>
                                    <p>No Image</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php if ($totalPages > 1) : ?>
                    <div class="text-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="dashboard.php?page=<?= $page - 1 ?>"> << Previous</a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="dashboard.php?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($page < $totalPages) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="dashboard.php?page=<?= $page + 1 ?>"> >> Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer" style="background-color: #333;">
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

        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const navbarBrand = document.getElementById("navbarBrand");

            navbarBrand.addEventListener("click", function(event) {
                event.preventDefault();

                if (sidebar.classList.contains("sidebar-open")) {
                    sidebar.classList.remove("sidebar-open");
                    sidebar.classList.add("sidebar-closed");
                } else {
                    sidebar.classList.remove("sidebar-closed");
                    sidebar.classList.add("sidebar-open");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
