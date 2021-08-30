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
<h2>Data Anggota</h2>
<table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>Gender</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
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
                    </tr>";
            }
        } ?>
    </tbody>
</table>

<script>
    window.print()
</script>