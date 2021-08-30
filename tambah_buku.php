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

    <title>Form Input Buku</title>
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
                        <h5 class="card-title">Form Input Data Buku</h5>
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
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="id_buku">ID Buku</label>

                                <?php

                                // import koneksi database
                                include 'koneksi.php';

                                // sintaks kueri mengambil nilai tertinggi dari id buku
                                $sql = "SELECT MAX(id_buku) as maxKode FROM tbbuku";
                                // melakukan kueri
                                $buku = $conn->query($sql);
                                $buku = $buku->fetch_assoc();

                                // fungsi untuk membuat id auto increment dengan gabungan huruf
                                function id_buku($auto_id)
                                {
                                    $id = (int) substr($auto_id, 3, 3);
                                    $id++;

                                    $huruf = "B";
                                    $newID = $huruf . sprintf("%03s", $id);
                                    echo $newID;
                                }
                                ?>

                                <input type="text" class="form-control" name="id_buku" id="id_buku" value="<?php id_buku($buku["maxKode"]) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Pengarang</label>
                                <input type="text" name="pengarang" id="pengarang" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" name="kategori" id="kategori" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan</button>
                        </form>
                        <?php

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            $judul = $_POST["judul"];
                            $id_buku = $_POST["id_buku"];
                            $pengarang = $_POST["pengarang"];
                            $penerbit = $_POST["penerbit"];
                            $kategori = $_POST["kategori"];
                            $tahun = $_POST["tahun"];

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
                            $file_foto = $id_buku . "." . $ext;
                            if (in_array($ext, ["jpg", "png"])) {
                                if ($size > $maxSize) {
                                    $_SESSION["error"] = "<strong>Oopps!</strong> File yang diupload terlalu besar max 1MB";
                                    echo "<script>window.location='tambah_buku.php'</script>";
                                } else {
                                    $sql = "INSERT INTO tbbuku VALUES ('$id_buku', '$judul', '$pengarang', '$penerbit', '$kategori', '$tahun', '$file_foto')";
                                    if ($conn->query($sql) == TRUE) {
                                        // path buat upload foto
                                        $path = "images/book/$file_foto";
                                        move_uploaded_file($lokasi_file, $path);

                                        $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil disimpan";
                                        echo "<script>window.location='buku.php'</script>";
                                    }
                                }
                            } else {
                                $_SESSION["error"] = "<strong>Oopps!</strong> File yang diperbolehkan hanya .png/.jpg";
                                echo "<script>window.location='tambah_buku.php'</script>";
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