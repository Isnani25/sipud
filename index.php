<?php session_start();

if (isset($_SESSION["nama_admin"])) {
    echo "<script>window.location='home.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 350px;
            padding: 15px;
            margin: auto;
        }
    </style>

    <title>Login</title>
</head>

<body class="text-center">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" class="form-signin border rounded" method="POST">

        <?php if (isset($_SESSION["error"])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION["error"]; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php unset($_SESSION["error"]) ?>

        <img src="images\membuat-form-login-min.png" alt="img" class="mb-4" width="150" height="170" />
        <h3 class="mb-3 font-weight-normal">LOGIN</h3>

        <div class="form-group">
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username..." required />
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password..." required />
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Submit
            <i data-feather="arrow-right" class="float-right"></i>
        </button>
        <div class="mt-3 mb-3">

           <!-- <p class="text-muted">Username: Isnani Password: 12345</p> 
            <p class="text-muted">
                Made with <span class="text-danger">&#10084;</span> by Isnani .
            </p> -->
        </div>
        <?php

        // import koneksi database
        include_once 'koneksi.php';

        // jika ada data masuk
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // mengambil username dan password dari form
            $username = $_POST['username'];
            $password = $_POST['password'];

            // melakukan query ke database
            $sql = "SELECT * FROM tbadmin WHERE username = '$username'";
            $data_admin = $conn->query($sql);

            // pengecekan jika ditemukan akun admin
            if ($data_admin->num_rows > 0) {
                $data_admin = $data_admin->fetch_assoc();

                // pengecekan password 
                if (password_verify($password, $data_admin["password"])) {
                    $_SESSION["nama_admin"] = $data_admin["nama_admin"];
                    $_SESSION['id_admin'] = $data_admin["id_admin"];
                    echo "<script>window.location='home.php'</script>";
                }
                // jika password salah
                else {
                    $_SESSION['error'] = "<strong>Oopps!</strong> Password salah";
                    echo "<script>window.location='index.php'</script>";
                }
            }
            // jika tidak ada akun admin yang ditemukan
            else {
                $_SESSION['error'] = "<strong>Oopps!</strong> Username tidak ditemukan didalam database";
                echo "<script>window.location='index.php'</script>";
            }
        }
        ?>
    </form>


    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script>
        feather.replace()
    </script>
</body>

</html>