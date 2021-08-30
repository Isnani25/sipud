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

    <title>Transaksi Peminjaman</title>
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
                        <h5 class="card-title">Tampil Transaksi Peminjaman</h5>
                        <div class="ml">
                            <a href="tambah_peminjaman.php" class="btn btn-primary">
                                <i class="fad fa-plus-square"></i>
                                Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-peminjam" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Foto</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Petugas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
    
                                    // import koneksi database
                                    include 'koneksi.php';
    
                                    // sintaks kueri menampilkan data peminjam
                                    $sql = "SELECT tbpeminjam.id_peminjaman, tbpeminjam.tanggal_pinjam, tbpeminjam.tanggal_kembali, tbadmin.nama_admin, tbbuku.judul, tbbuku.foto, tbanggota.id_anggota, tbanggota.nama FROM tbpeminjam 
                                    INNER JOIN tbbuku ON tbpeminjam.id_buku = tbbuku.id_buku
                                    INNER JOIN tbanggota ON tbpeminjam.id_anggota = tbanggota.id_anggota
                                    INNER JOIN tbadmin ON tbpeminjam.id_petugas = tbadmin.id_admin";
    
                                    // melakukan kueri
                                    $data_peminjam = $conn->query($sql);
    
                                    $no = 1;
    
                                    // pengecekan jika ada data dalam table peminjam
                                    if ($data_peminjam->num_rows > 0) {
                                        foreach ($data_peminjam as $peminjam) {
                                            echo "<tr>
                                                <td>" . $no . "</td>
                                                <td>" . $peminjam["judul"] . "</td>
                                                <td><img src='images/book/" . $peminjam["foto"] . "' alt='" . $peminjam["judul"] . "' class='img-thumbnail' width='100'/></td>
                                                <td>" . $peminjam["nama"] . "</td>
                                                <td>" . $peminjam["tanggal_pinjam"] . "</td>
                                                <td>" . $peminjam["tanggal_kembali"] . "</td>
                                                <td>" . $peminjam["nama_admin"] . "</td>
                                                <td>
                                                <a href='javascript:void(0)' class='badge badge-pill badge-danger hapus' data-toggle='modal' data-target='#modalDelete' data-peminjam=" . $peminjam["id_peminjaman"] . " data-anggota=" . $peminjam["id_anggota"] . ">Hapus</a>
                                                </td>
                                            </tr>";
                                            $no++;
                                        }
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Foto</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Kembali</th>
                                        <th>Petugas</th>
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
                        <input type="hidden" name="id_peminjam" id="id_peminjam">
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
        $id_peminjam = $_POST["id_peminjam"];
        $id_anggota = $_POST["id_anggota"];

        if ($conn->query("DELETE FROM tbpeminjam WHERE id_peminjaman='$id_peminjam'") == TRUE) {
            // update status anggota
            $anggota = $conn->query("UPDATE tbanggota SET status = 'Tidak Meminjam' WHERE id_anggota='$id_anggota'");

            $_SESSION["success"] = "<strong>Yeay!</strong> Data berhasil dihapus";
            echo "<script>window.location='peminjam.php'</script>";
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
            $('#table-peminjam').DataTable();

            $(".hapus").on("click", function() {
                let idPeminjam = $(this).attr("data-peminjam");
                let inputPeminjam = $("#id_peminjam");
                inputPeminjam.val(idPeminjam);

                let idAnggota = $(this).attr("data-anggota");
                let inputAnggota = $("#id_anggota");
                inputAnggota.val(idAnggota);
            });
        });
    </script>
</body>

</html>