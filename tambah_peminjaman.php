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

    <style>
        .btn:disabled {
            cursor: not-allowed;

        }
    </style>

    <title>Tambah Peminjaman</title>
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
                <div id="alert">

                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Form Peminjaman Buku</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ID Buku</label>
                                        <input type="text" name="id_buku" id="id_buku" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ID Anggota</label>
                                        <input type="text" name="id_anggota" id="id_anggota" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tanggal Kembali</label>
                                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success cari">Cari</button>
                            <div id="detail" class="mt-3 mb-3"></div>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            include 'koneksi.php';

                            $id_buku = strtoupper($_POST["id_buku"]);
                            $id_anggota = strtoupper($_POST["id_anggota"]);
                            $tanggal_pinjam = date('Y-m-d');
                            $tanggal_kembali = $_POST["tanggal_kembali"];
                            $id_petugas = $_SESSION['id_admin'];

                            $insertPeminjam = "INSERT INTO tbpeminjam (id_peminjaman, id_buku, tanggal_pinjam, tanggal_kembali, id_anggota, id_petugas) VALUES ('', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', '$id_anggota', '$id_petugas')";
                            $updateStatus = "UPDATE tbanggota SET status = 'Meminjam' WHERE id_anggota = '$id_anggota'";

                            if ($conn->query($insertPeminjam) == TRUE) {
                                // update status peminjam
                                $conn->query($updateStatus);
                                $conn->close();
                                $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil disimpan";
                                echo "<script>window.location='peminjam.php'</script>";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->

    <script src="js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('.cari').on("click", function() {
            let idBuku = $('#id_buku').val();
            let idAnggota = $('#id_anggota').val();

            if (!idBuku || !idAnggota) {
                $("#alert").html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert"> form harus di isi <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                );
            } else {
                $.ajax({
                    type: "POST",
                    url: "get_data_peminjam.php",
                    data: {
                        idBuku: idBuku,
                        idAnggota: idAnggota,
                    },
                    cache: false,
                    success: function(data) {
                        $('#detail').html(data)
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            }
        })
    </script>
</body>

</html>