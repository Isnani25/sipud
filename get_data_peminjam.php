<?php

if(empty($_POST)){
    header("Location: 403.html");
} 
$idBuku = strtoupper($_POST["idBuku"]);
$idAnggota = strtoupper($_POST["idAnggota"]);

include "koneksi.php";

$buku = $conn->query("SELECT * FROM tbbuku WHERE id_buku = '$idBuku'");
if ($buku->num_rows > 0) :
    $buku = $buku->fetch_assoc();
?>
    <h5 class="text-center">Detail Buku</h5>
    <hr>
    <div class="form-group text-center">
        <img src="images/book/<?= $buku["foto"] ?>" alt="<?= $buku["judul"] ?>" class="img-thumbnail" width="100">
        <h5><?= $buku["judul"] ?></h5>
    </div>
    <div class="form-group">
        <label>Pengarang</label>
        <input type="text" name="pengarang" id="pengarang" class="form-control" value="<?= $buku["pengarang"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" class="form-control" value="<?= $buku["penerbit"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control" value="<?= $buku["kategori"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="tahun">Tahun</label>
        <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $buku["tahun"] ?>" readonly>
    </div>
<?php

else :
    echo "<h5 class='text-center'>Detail Buku</h5>";
    echo "<p>Data tidak ditemukan....</p>";
endif;

$anggota = $conn->query("SELECT * FROM tbanggota WHERE id_anggota = '$idAnggota'");
if ($anggota->num_rows > 0) :
    $anggota = $anggota->fetch_assoc();
?>

    <h5 class="text-center">Detail Anggota</h5>
    <hr>
    <div class="form-group text-center">
        <img src="images/member/<?= $anggota["foto"] ?>" alt="<?= $anggota["nama"] ?>" class="img-thumbnail" width="100">
        <h5><?= $anggota["nama"] ?></h5>
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" value="<?= $anggota["gender"] ?>" readonly>
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control" readonly><?= $anggota["alamat"]; ?></textarea>
    </div>
    <div class="form-group">
        <label for="status">Status</label><br>
        <?php if ($anggota["status"] == "Meminjam") : ?>
            <span class="btn btn-warning text-white"><i class="fas fa-spinner"></i> <?= $anggota["status"]; ?></span>
        <?php else : ?>
            <span class="btn btn-success text-white"><i class="fas fa-check"></i> <?= $anggota["status"]; ?></span>
        <?php endif; ?>
    </div>

    <button type="submit" name="submit" class="btn btn-primary" <?= ($anggota["status"] == "Meminjam") ? 'disabled' : ''  ?>>
        <i class="fas fa-save"></i>
        Simpan</button>

<?php

endif;
exit;
?>