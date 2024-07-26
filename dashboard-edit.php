<?php
include 'koneksi.php';

if (isset($_POST['update'])) {
    $id_barang = $_POST['id_barang'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $asal = $_POST['asal'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];
    $tanggal_diterima = $_POST['tanggal_diterima'];

    $gambar = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $folder = "img/";
    move_uploaded_file($tmp_file, $folder . $gambar);

    $update = mysqli_query($koneksi, "UPDATE barang SET kode = '$kode', nama = '$nama', asal = '$asal', jumlah = '$jumlah', satuan = '$satuan', tanggal_diterima = '$tanggal_diterima', gambar = '$gambar' WHERE id_barang = '$id_barang'");

    if ($update) {
        header("location: dashboard-edit.php");
    } else {
        echo "Gagal";
        header("location: dashboard-edit.php?id_barang=$id_barang");
    }
}

if(isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = '$id_barang'") or die(mysqli_error($koneksi));

    header("location:dashboard-edit.php");
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
                    <a class="nav-link" aria-current="page" href="dashboard.php">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="input.php">Tambah Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active-link" href="dashboard-edit.php">Pengaturan</a>
                </li>
            </ul>
        </div>

        <div class="container-fluid">
            <div class="card mt-3 mx-auto" style="max-width: 1000px;">
                <div class="card-header text-light text-center" style="background-color: #333;">
                    Ubah/Hapus Data
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-striped table-hover table-bordered">
                        <tr>
                            <th>No.</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Asal Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Diterima</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $no = 1;
                        $show = mysqli_query($koneksi, "SELECT * FROM barang order by id_barang asc");
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
                                <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editMenu" data-id="<?php echo $data['id_barang']; ?>" data-kode="<?php echo $data['kode']; ?>" data-nama="<?php echo $data['nama']; ?>" data-asal="<?php echo $data['asal']; ?>" data-jumlah="<?php echo $data['jumlah']; ?>" data-satuan="<?php echo $data['satuan']; ?>" data-tanggal="<?php echo $data['tanggal_diterima']; ?>">Edit</button>
                                    <a class="btn btn-secondary" href="javascript:confirmDelete('<?php echo $data['id_barang']; ?>')">Hapus</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="card-footer" style="background-color: #333;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMenu" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Edit Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="dashboard-edit.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Barang</label>
                            <input type="text" name="kode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="asal" class="form-label">Asal Barang</label>
                            <select class="form-select" name="asal" required>
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="Pembelian">Pembelian</option>
                                <option value="Hibah">Hibah</option>
                                <option value="Sumbangan">Sumbangan</option>
                                <option value="Bantuan">Bantuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" name="satuan" required>
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="Unit">Unit</option>
                                <option value="Kotak">Kotak</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Pak">Pak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control">
                        </div>
                        <input type="hidden" name="id_barang" id="editIdBarang">
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                    </form>
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

    <script>
        const editMenu = document.getElementById('editMenu');
        editMenu.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const idBarang = button.getAttribute('data-id');
            const kodeBarang = button.getAttribute('data-kode');
            const namaBarang = button.getAttribute('data-nama');
            const asalBarang = button.getAttribute('data-asal');
            const jumlahBarang = button.getAttribute('data-jumlah');
            const satuanBarang = button.getAttribute('data-satuan');
            const tanggalBarang = button.getAttribute('data-tanggal');
            
            document.getElementById('editIdBarang').value = idBarang;
            document.querySelector('#editMenu [name="kode"]').value = kodeBarang;
            document.querySelector('#editMenu [name="nama"]').value = namaBarang;
            document.querySelector('#editMenu [name="asal"]').value = asalBarang;
            document.querySelector('#editMenu [name="jumlah"]').value = jumlahBarang;
            document.querySelector('#editMenu [name="satuan"]').value = satuanBarang;
            document.querySelector('#editMenu [name="tanggal_diterima"]').value = tanggalBarang;
        });
    </script>

    <script>
        function confirmDelete(id_barang) {
            if (confirm('Apakah Anda yakin ingin menghapus data?')) {
                window.location.href = 'dashboard-edit.php?id_barang=' + id_barang;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>