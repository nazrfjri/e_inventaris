<?php
include 'koneksi.php';

if (isset($_POST['bsimpan'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $asal = $_POST['asal'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $tanggal_diterima = $_POST['tanggal_diterima'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($gambar_tmp, "uploads/" . $gambar);
    } else {
        $gambar = "";
    }

    mysqli_query($koneksi, "INSERT INTO barang (kode, nama, asal, jumlah, satuan, tanggal_diterima, gambar)
                            VALUES ('$kode', '$nama', '$asal', '$jumlah', '$satuan', '$tanggal_diterima', '$gambar')") or die(mysqli_error($koneksi));

    echo "Data Berhasil Tersimpan";

    header("Location: dashboard.php");
    exit();
}
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
    <title>Input Data</title>
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
                    <a class="nav-link" aria-current="page" href="dashboard.php">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active-link" href="input.php">Tambah Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard-edit.php">Pengaturan</a>
                </li>
            </ul>
        </div>

        <div class="container"><br>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header text-light text-center" style="background-color: #333;">
                            Input Data Barang
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Kode Barang</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Masukkan Kode Barang" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Barang" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Asal Barang</label>
                                    <select class="form-select" name="asal" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Pembelian">Pembelian</option>
                                        <option value="Hibah">Hibah</option>
                                        <option value="Sumbangan">Sumbangan</option>
                                        <option value="Bantuan">Bantuan</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah</label>
                                            <input type="number" name="jumlah" class="form-control" placeholder="Masukkan Jumlah Barang" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label">Satuan</label>
                                            <select class="form-select" name="satuan" required>
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Unit">Unit</option>
                                                <option value="Kotak">Kotak</option>
                                                <option value="Pcs">Pcs</option>
                                                <option value="Pak">Pak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Diterima</label>
                                            <input type="date" name="tanggal_diterima" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" name="gambar" class="form-control">
                                </div>
                                <div class="text-center">
                                    <hr>
                                    <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                                    <button class="btn btn-danger" name="bkosongkan" type="submit">Kosongkan</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer" style="background-color: #333;"></div>
                    </div>
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