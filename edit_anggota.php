<?php

session_start();
if (empty($_SESSION["nama_admin"])) {
    $_SESSION["error"] = "<strong>Oopps!</strong> Login terlebih dahulu";
    echo "<script>window.location='index.php'</script>";
}

if (empty($_GET["id"])) {
    echo "<script>window.location='javascript:history.go(-1)'</script>";
} else {
    // import koneksi database
    include 'koneksi.php';

    $id_anggota = $_GET['id'];
    $sql = "SELECT * FROM tbanggota WHERE id_anggota='$id_anggota'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $anggota = $result->fetch_assoc();

        $id_anggota = $anggota["id_anggota"];
        $nama = $anggota["nama"];
        $gender = $anggota["gender"];
        $alamat = $anggota["alamat"];
        $foto = $anggota["foto"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <title>Form Edit Anggota</title>
</head>

<body>

    <?php include 'navbar.php' ?>

    <div class="container">
        <div class="row">
            <div class="col-md">
                <?php if (isset($_SESSION["error"])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION["error"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION["error"]); ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Edit Data Anggota</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER["PHP_SELF"] . "?id=" . $id_anggota ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="foto">Foto</label><br>
                                <img src="images/member/<?= $foto ?>" alt="<?= $nama ?>" class="img-thumbnail mb-2" width="100">
                                <input type="hidden" name="old_photo" value="<?= $foto ?>">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto" accept=".jpg,.png">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id_anggota" value="<?= $id_anggota ?>">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="<?= $nama ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelamin1" value="Pria" <?= ($gender == "Pria") ? 'checked' : ''  ?> required>
                                            <label class="form-check-label" for="jenisKelamin1">Pria</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelamin2" value="Wanita" <?= ($gender == "Wanita") ? 'checked' : ''  ?>>
                                            <label class="form-check-label" for="jenisKelamin2">Wanita</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="2" class="form-control" required><?= $alamat; ?></textarea>
                            </div>
                            <a href="javascript:history.go(-1)" class="btn btn-dark">
                                <i class="fas fa-arrow-circle-left"></i>
                                Go back</a>
                            <button type="submit" name="submit" class="btn btn-success">
                                <i class="fas fa-save"></i>
                                Ubah</button>
                        </form>
                        <?php

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            include_once 'koneksi.php';

                            $nama = $_POST["nama"];
                            $gender = $_POST["jenisKelamin"];
                            $id_anggota = $_POST["id_anggota"];
                            $alamat = $_POST["alamat"];
                            $old_photo = $_POST['old_photo'];

                            // ambil nama file
                            $nama_file = $_FILES["foto"]["name"];

                            // ambil lokasi sementara upload
                            $lokasi_file = $_FILES["foto"]["tmp_name"];

                            // ambil ekstensi file
                            $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

                            // ambil ukuran file
                            $size = $_FILES["foto"]["size"];
                            // set max upload file 1MB
                            $maxSize = 1000000;

                            // membuat nama file foto
                            $file_foto = $id_anggota . "." . $ext;

                            if (!empty($_FILES["foto"]["name"])) {
                                if (in_array($ext, ["jpg", "png"])) {
                                    if ($size > $maxSize) {
                                        $_SESSION["error"] = "<strong>Oopps!</strong> File yang diupload terlalu besar max 1MB";
                                        echo "<script>window.location='edit_anggota.php?id=" . $id_anggota . "'</script>";
                                    } else {
                                        // menghapus foto lama
                                        unlink("images/member/$old_photo");

                                        $sql = "UPDATE tbanggota SET nama='$nama', gender='$gender', alamat='$alamat', foto='$file_foto' WHERE id_anggota='$id_anggota'";
                                        if ($conn->query($sql) == TRUE) {
                                            // path buat upload foto
                                            $path = "images/member/$file_foto";
                                            move_uploaded_file($lokasi_file, $path);

                                            $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil disimpan";
                                            echo "<script>window.location='anggota.php'</script>";
                                        }
                                    }
                                } else {
                                    $_SESSION["error"] = "<strong>Oopps!</strong> File yang diperbolehkan hanya .png/.jpg";
                                    echo "<script>window.location='edit_anggota.php?id=" . $id_anggota . "'</script>";
                                }
                            } else {
                                $sql = "UPDATE tbanggota SET nama='$nama', gender='$gender', alamat='$alamat' WHERE id_anggota='$id_anggota'";
                                if ($conn->query($sql) == TRUE) {
                                    $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil diupdate";
                                    echo "<script>window.location='anggota.php'</script>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Container -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
</body>

</html>