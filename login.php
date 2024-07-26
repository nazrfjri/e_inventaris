<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nama'])) {
        $nama = $_POST['nama'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    if (isset($email)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($koneksi, $query);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            $insert_query = "INSERT INTO users (nama, email, username, password) VALUES ('$nama', '$email', '$username', '$hashed_password')";
            if (mysqli_query($koneksi, $insert_query)) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
            }
        } else {
            $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
        }
    } else {
        $error_message = "Mohon isi semua field yang diperlukan.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Username atau password salah. Silakan coba lagi.";
        }
    } else {
        $error_message = "Username atau password salah. Silakan coba lagi.";
    }
}

mysqli_close($koneksi);
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
            font-family: 'Poppins', sans-serif;
            background-image: url('img/inv8.jpg');
        }
        .navbar {
            background-color: #333;
            padding: 10px;
        }
        .navbar-brand,
        .navbar-text {
            color: #fff;
        }
        .navbar-text {
            margin-right: 15px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .card-body-welcome {
            background-color: #333;
            color: #fff;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .card-body-form {
            background-color: #fff;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .signup-link {
            color: #fff;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
    <title>Halaman Login/Signup</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">E-Inventaris</a>
        </div>
    </nav>

    <div class="container mt-5">
    <div class="card rounded shadow">
        <div class="row g-5">
            <div class="col-md-6 text-light p-5 rounded-start" style="background-color: #333;">
                <h2>Selamat datang!</h2>
                <p>Silakan login untuk masuk.</p>
                <p>Belum punya akun? <span class="signup-link" data-bs-toggle="modal" data-bs-target="#registerMenu">Registrasi</span></p>
            </div>
            <div class="col-md-6 bg-light p-5 rounded-end">
                <h2>Login</h2>

                <?php
                if (isset($error_message)) {
                    echo '<p style="color: red;">' . $error_message . '</p>';
                }
                ?>

                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div>
                        <input type="submit" value="Login" class="btn btn-primary">
                    </div>
                </form>
                
                <div class="modal fade" id="registerMenu" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerLabel">Registrasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Registrasi</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>