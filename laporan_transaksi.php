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

    <title>Laporan Transaksi</title>
</head>

<body>

    <?php include 'navbar.php' ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tampil Transaksi Pengembalian</h5>
                        <a href="cetak_pengembalian.php" class="btn btn-success">
                            <i class="fas fa-print"></i>
                            Cetak
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-pengembali" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Foto</th>
                                        <th>Pengembali</th>
                                        <th>Tgl Kembali</th>
                                        <th>Denda</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    // import koneksi database
                                    include 'koneksi.php';

                                    // sintaks kueri menampilkan data peminjam
                                    $sql = "SELECT tbpengembalian.id_pengembalian, tbbuku.foto, tbbuku.judul, tbanggota.nama, tbpengembalian.tanggal_pengembalian, tbpengembalian.denda, tbadmin.nama_admin
                                    FROM tbpengembalian 
                                    INNER JOIN tbbuku ON tbpengembalian.id_buku = tbbuku.id_buku
                                    INNER JOIN tbanggota ON tbpengembalian.id_anggota = tbanggota.id_anggota
                                    INNER JOIN tbadmin ON tbpengembalian.id_petugas = tbadmin.id_admin";

                                    // melakukan kueri
                                    $data_pengembalian = $conn->query($sql);
                                    $no = 1;

                                    // pengecekan jika ada data dalam table pengembali
                                    if ($data_pengembalian->num_rows > 0) {
                                        foreach ($data_pengembalian as $pengembalian) {
                                            echo "<tr>
                                                <td>" . $no . "</td>
                                                <td>" . $pengembalian["judul"] . "</td>
                                                <td><img src='images/book/" . $pengembalian["foto"] . "' alt='" . $pengembalian["judul"] . "' class='img-thumbnail' width='100'/></td>
                                                <td>" . $pengembalian["nama"] . "</td>
                                                <td>" . date("d-m-Y", strtotime($pengembalian["tanggal_pengembalian"])) . "</td>
                                                <td>" . $pengembalian["denda"] . "</td>
                                                <td>" . $pengembalian["nama_admin"] . "</td>
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
                                        <th>Pengembali</th>
                                        <th>Tgl Kembali</th>
                                        <th>Denda</th>
                                        <th>Petugas</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tampil Transaksi Peminjaman</h5>
                        <a href="cetak_peminjam.php" class="btn btn-success">
                            <i class="fas fa-print"></i>
                            Cetak
                        </a>
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

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table-pengembali').DataTable();
            $('#table-peminjam').DataTable();
        });
    </script>
</body>

</html>