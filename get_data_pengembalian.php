<?php

if (empty($_POST)) {
    header("Location: 403.html");
}
$idBuku = strtoupper($_POST["idBuku"]);
$idAnggota = strtoupper($_POST["idAnggota"]);

function denda($endDays)
{
    $today = date("Y-m-d");
    if ($today > $endDays) {
        $tglKembalikan = strtotime($endDays);
        $sekarang = strtotime($today);

        $jarakWaktu = abs($tglKembalikan - $sekarang);
        $hari = $jarakWaktu / 86400;

        $hari = intval($hari) * 5000;
        return $hari;
    } else {
        return 0;
    }
}

include "koneksi.php";

$pengembalian = $conn->query("SELECT tbpeminjam.id_peminjaman, tbpeminjam.tanggal_pinjam, tbpeminjam.tanggal_kembali, tbbuku.judul, tbbuku.pengarang, tbbuku.penerbit, tbbuku.kategori, tbbuku.tahun, tbbuku.foto AS book_photo, tbanggota.id_anggota, tbanggota.nama, tbanggota.gender, tbanggota.alamat, tbanggota.foto AS member_photo FROM tbpeminjam 
                                INNER JOIN tbbuku ON tbpeminjam.id_buku = tbbuku.id_buku
                                INNER JOIN tbanggota ON tbpeminjam.id_anggota = tbanggota.id_anggota
                                INNER JOIN tbadmin ON tbpeminjam.id_petugas = tbadmin.id_admin
                                WHERE tbpeminjam.`id_buku` = '$idBuku' AND tbpeminjam.`id_anggota` = '$idAnggota'");
if ($pengembalian->num_rows > 0) :
    $pengembalian = $pengembalian->fetch_assoc();
?>
    <h5 class="text-center">Detail Buku</h5>
    <hr>
    <div class="form-group text-center">
        <img src="images/book/<?= $pengembalian["book_photo"] ?>" alt="<?= $pengembalian["judul"] ?>" class="img-thumbnail" width="100">
        <h5><?= $pengembalian["judul"] ?></h5>
    </div>
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" class="form-control" value="<?= $pengembalian["pengarang"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" class="form-control" value="<?= $pengembalian["penerbit"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control" value="<?= $pengembalian["kategori"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="tahun">Tahun</label>
        <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $pengembalian["tahun"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="tanggal_pinjam">Tanggal Pinjam</label>
        <input type="text" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="<?= date("l, d F Y", strtotime($pengembalian["tanggal_pinjam"])) ?>" readonly>
    </div>
    <div class="form-group">
        <label for="tanggal_kembali">Tanggal Kembali</label>
        <input type="text" name="tanggal_kembali" id="tanggal_kembali" class="form-control" value="<?= date("l, d F Y", strtotime($pengembalian["tanggal_kembali"])) ?>" readonly>
    </div>
    <div class="form-group">
        <label for="denda">Denda</label>
        <input type="hidden" name="id_peminjaman" value="<?= $pengembalian["id_peminjaman"] ?>">
        <input type="text" name="denda" id="denda" class="form-control" value="<?= denda($pengembalian["tanggal_kembali"]) ?>" readonly>
    </div>

    <h5 class="text-center">Detail Anggota</h5>
    <hr>
    <div class="form-group text-center">
        <img src="images/member/<?= $pengembalian["member_photo"] ?>" alt="<?= $pengembalian["nama"] ?>" class="img-thumbnail" width="100">
        <h5><?= $pengembalian["nama"] ?></h5>
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $pengembalian["gender"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control" readonly><?= $pengembalian["alamat"]; ?></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan</button>

<?php

endif;
exit;
?>