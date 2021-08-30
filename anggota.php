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

    <title>Data Anggota</title>
</head>

<body>

    <?php include 'navbar.php' ?>

    <div class="container">
        <div class="row">
            <div class="col-md">
                <?php if (isset($_SESSION["success"])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION["success"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION["success"]); ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tampil Data Anggota</h5>
                        <div class="ml">
                            <a href="tambah_anggota.php" class="btn btn-primary">
                                <i class="fad fa-plus-square"></i>
                                Tambah
                            </a>
                            <a href="cetak_anggota.php" class="btn btn-success">
                                <i class="fas fa-print"></i>
                                Cetak
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-anggota" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Foto</th>
                                        <th>Gender</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
    
                                    // import koneksi database
                                    include 'koneksi.php';
    
                                    // sintaks kueri menampilkan data anggota
                                    $sql = "SELECT * FROM tbanggota";
    
                                    // melakukan kueri
                                    $data_anggota = $conn->query($sql);
    
                                    // pengecekan jika ada data dalam table anggota
                                    if ($data_anggota->num_rows > 0) {
                                        foreach ($data_anggota as $anggota) {
                                            echo "<tr>
                                                <td>" . $anggota["id_anggota"] . "</td>
                                                <td>" . $anggota["nama"] . "</td>
                                                <td><img src='images/member/" . $anggota["foto"] . "' alt='" . $anggota["nama"] . "' class='img-thumbnail' width='50'/></td>
                                                <td>" . $anggota["gender"] . "</td>
                                                <td>" . $anggota["alamat"] . "</td>
                                                <td>" . $anggota["status"] . "</td>
                                                <td>
                                                <a href=edit_anggota.php?id=" . $anggota["id_anggota"] . " class='badge badge-pill badge-success'>Edit</a>
                                                <a href='javascript:void(0)' class='badge badge-pill badge-danger hapus' data-toggle='modal' data-target='#modalDelete' data-id=" . $anggota["id_anggota"] . ">Hapus</a>
                                                </td>
                                            </tr>";
                                        }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Foto</th>
                                        <th>Gender</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Container -->

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDeleteLabel">Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah yakin ingin menghapus data?</p>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="id_anggota" id="id_anggota">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id_anggota = $_POST["id_anggota"];

        $anggota = $conn->query("SELECT foto FROM tbanggota WHERE id_anggota='$id_anggota'");
        $anggota = $anggota->fetch_assoc();
        unlink("images/member/" . $anggota["foto"]);

        if ($conn->query("DELETE FROM tbanggota WHERE id_anggota='$id_anggota'") == TRUE) {
            $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil dihapus";
            echo "<script>window.location='anggota.php'</script>";
        }
    }
    ?>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-anggota').DataTable();

            $(".hapus").on("click", function() {
                let id_data = $(this).attr("data-id");
                let set_input_id = $("#id_anggota");
                set_input_id.val(id_data);
            });
        });
    </script>
</body>

</html>