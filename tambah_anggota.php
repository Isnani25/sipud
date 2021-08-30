<?php

session_start();
if (empty($_SESSION["nama_admin"])) {
    $_SESSION["error"] = "<strong>Oopps!</strong> Login terlebih dahulu";
    echo "<script>window.location='index.php'</script>";
} ?>
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

    <title>Form Input Anggota</title>
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
                        <h5 class="card-title">Form Input Data Anggota</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto" required accept=".jpg,.png">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="id_anggota">ID Anggota</label>

                                <?php

                                // import koneksi database
                                include 'koneksi.php';

                                // sintaks kueri mengambil nilai tertinggi dari id anggota
                                $sql = "SELECT MAX(id_anggota) as maxKode FROM tbanggota";
                                // melakukan kueri
                                $anggota = $conn->query($sql);
                                $anggota = $anggota->fetch_assoc();

                                // fungsi untuk membuat id auto increment dengan gabungan huruf
                                function id_anggota($auto_id)
                                {
                                    $id = (int) substr($auto_id, 3, 3);
                                    $id++;

                                    $huruf = "A";
                                    $newID = $huruf . sprintf("%03s", $id);
                                    echo $newID;
                                }
                                ?>

                                <input type="text" class="form-control" name="id_anggota" id="id_anggota" value="<?php id_anggota($anggota["maxKode"]) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelamin1" value="Pria" required>
                                            <label class="form-check-label" for="jenisKelamin1">Pria</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelamin2" value="Wanita">
                                            <label class="form-check-label" for="jenisKelamin2">Wanita</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="2" class="form-control" required></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan</button>
                        </form>
                        <?php

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $nama = $_POST["nama"];
                            $gender = $_POST["jenisKelamin"];
                            $id_anggota = $_POST["id_anggota"];
                            $alamat = $_POST["alamat"];
                            $status = "Tidak Meminjam";

                            // ambil nama file
                            $nama_file = $_FILES["foto"]["name"];
                            // ambil lokasi sementara upload
                            $lokasi_file = $_FILES["foto"]["tmp_name"];
                            // ambil ekstensi file
                            $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
                            // ambil ukuran file
                            $size = $_FILES["foto"]["size"];
                            $maxSize = 1000000;

                            // membuat nama file foto
                            $file_foto = $id_anggota . "." . $ext;
                            if (in_array($ext, ["jpg", "png"])) {
                                if ($size > $maxSize) {
                                    $_SESSION["error"] = "<strong>Oopps!</strong> File yang diupload terlalu besar max 1MB";
                                    echo "<script>window.location='tambah_anggota.php'</script>";
                                } else {
                                    $sql = "INSERT INTO tbanggota VALUES ('$id_anggota', '$nama', '$gender', '$alamat', '$status', '$file_foto')";
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
                                echo "<script>window.location='tambah_anggota.php'</script>";
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