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

    <title>Data Buku</title>
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
                        <h5 class="card-title">Tampil Data Buku</h5>
                        <div class="ml">
                            <a href="tambah_buku.php" class="btn btn-primary">
                                <i class="fad fa-plus-square"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-buku" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Foto</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Kategori</th>
                                        <th>Tahun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
    
                                    // import koneksi database
                                    include 'koneksi.php';
    
                                    // sintaks kueri menampilkan data anggota
                                    $sql = "SELECT * FROM tbbuku";
    
                                    // melakukan kueri
                                    $data_buku = $conn->query($sql);
    
                                    // pengecekan jika ada data dalam table buku
                                    if ($data_buku->num_rows > 0) {
                                        foreach ($data_buku as $buku) {
                                            echo "<tr>
                                                <td>" . $buku["id_buku"] . "</td>
                                                <td>" . $buku["judul"] . "</td>
                                                <td><img src='images/book/" . $buku["foto"] . "' alt='" . $buku["judul"] . "'class='img-thumbnail' width='100'/></td>
                                                <td>" . $buku["pengarang"] . "</td>
                                                <td>" . $buku["penerbit"] . "</td>
                                                <td>" . $buku["kategori"] . "</td>
                                                <td>" . $buku["tahun"] . "</td>
                                                <td>
                                                <a href=edit_buku.php?id=" . $buku["id_buku"] . " class='badge badge-pill badge-success'>Edit</a>
                                                <a href='javascript:void(0)' class='badge badge-pill badge-danger hapus' data-toggle='modal' data-id='" . $buku["id_buku"] . "' data-target='#modalDelete'>Hapus</a>
                                                </td>
                                            </tr>";
                                        }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th>Kategori</th>
                                        <th>Tahun</th>
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
                    <p>Apakah anda yakin ingin menghapus ?</p>
                    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
                        <input type="hidden" name="id_buku" id="id_buku">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Modal -->

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id_buku = $_POST["id_buku"];

        $anggota = $conn->query("SELECT foto FROM tbbuku WHERE id_buku='$id_buku'");
        $anggota = $anggota->fetch_assoc();
        unlink("images/book/" . $anggota["foto"]);

        if ($conn->query("DELETE FROM tbbuku WHERE id_buku='$id_buku'") == TRUE) {
            $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil dihapus";
            echo "<script>window.location='buku.php'</script>";
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
            $('#table-buku').DataTable();

            $(".hapus").on("click", function() {
                let id_data = $(this).attr("data-id");
                let set_input_id = $("#id_buku");
                set_input_id.val(id_data);
            });
        });
    </script>
</body>

</html>