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

    $id_buku = $_GET['id'];
    $sql = "SELECT * FROM tbbuku WHERE id_buku='$id_buku'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $buku = $result->fetch_assoc();

        $id_buku = $buku["id_buku"];
        $judul = $buku["judul"];
        $pengarang = $buku["pengarang"];
        $penerbit = $buku["penerbit"];
        $kategori = $buku["kategori"];
        $tahun = $buku["tahun"];
        $foto = $buku["foto"];
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
                        <h5 class="card-title">Form Edit Data Buku</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER["PHP_SELF"] . "?id=" . $id_buku ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="foto">Foto</label><br>
                                <img src="images/book/<?= $foto ?>" alt="<?= $judul ?>" class="img-thumbnail" width="100">
                                <input type="hidden" name="old_photo" value="<?= $foto ?>">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto" accept=".jpg,.png">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
                                <input type="text" name="judul" id="judul" class="form-control" value="<?= $judul ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Pengarang</label>
                                <input type="text" name="pengarang" id="pengarang" class="form-control" value="<?= $pengarang ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" name="penerbit" id="penerbit" class="form-control" value="<?= $penerbit ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" name="kategori" id="kategori" class="form-control" value="<?= $kategori ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $tahun ?>" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success">
                                <i class="fas fa-save"></i>
                                Ubah</button>
                        </form>
                        <?php

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            include 'koneksi.php';

                            $judul = $_POST["judul"];
                            $id_buku = $_POST["id_buku"];
                            $pengarang = $_POST["pengarang"];
                            $penerbit = $_POST["penerbit"];
                            $kategori = $_POST["kategori"];
                            $tahun = $_POST["tahun"];
                            $old_photo = $_POST["old_photo"];

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
                            if (!empty($_FILES["foto"]["name"])) {
                                if (in_array($ext, ["jpg", "png"])) {
                                    if ($size > $maxSize) {
                                        $_SESSION["error"] = "<strong>Oopps!</strong> File yang diupload terlalu besar max 1MB";
                                        echo "<script>window.location='edit_buku.php?id=" . $id_buku . "'</script>";
                                    } else {
                                        // menghapus foto lama
                                        unlink("images/book/$old_photo");

                                        $sql = "UPDATE tbbuku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun='$tahun', foto='$file_foto' WHERE id_buku='$id_buku'";
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
                                    echo "<script>window.location='edit_buku.php?id=" . $id_buku . "'</script>";
                                }
                            } else {
                                $sql = "UPDATE tbbuku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun='$tahun' WHERE id_buku='$id_buku'";
                                if ($conn->query($sql) == TRUE) {
                                    $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil diupdate";
                                    echo "<script>window.location='buku.php'</script>";
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