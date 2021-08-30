<?php

session_start();
if (empty($_SESSION["nama_admin"])) {
    $_SESSION["error"] = "<strong>Oopps!</strong> Login terlebih dahulu";
    echo "<script>window.location='index.php'</script>";
} ?>
<style>
    * {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    td,
    th {
        border: 1px solid black;
    }

    th {
        background-color: #c9d3e2;
    }

    h2 {
        text-align: center;
    }
</style>
<h2>Laporan Transaksi Pengembalian Buku</h2>
<table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Foto</th>
            <th>Nama Pengembali</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
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
</table>
<script>
    window.print()
</script>