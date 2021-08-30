<header class="mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <a class="navbar-brand" href="home.php">SIPUS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= (basename($_SERVER['REQUEST_URI']) == "home.php") ? 'active' : '' ?>">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown <?= (basename($_SERVER['REQUEST_URI']) == "anggota.php" || basename($_SERVER['REQUEST_URI']) == "buku.php") ? 'active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDataMaster" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Data Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownDataMaster">
                        <a class="dropdown-item" href="anggota.php">Data Anggota</a>
                        <a class="dropdown-item" href="buku.php">Data Buku</a>
                    </div>
                </li>

                <li class="nav-item dropdown <?= (basename($_SERVER['REQUEST_URI']) == "pengembalian.php" || basename($_SERVER['REQUEST_URI']) == "peminjam.php") ? 'active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Data Transaksi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="peminjam.php">Transaksi Peminjaman</a>
                        <a class="dropdown-item" href="pengembalian.php">Transaksi Pengembalian</a>
                    </div>
                </li>
                <li class="nav-item <?= (basename($_SERVER['REQUEST_URI']) == "laporan_transaksi.php") ? 'active' : '' ?>">
                    <a class="nav-link" href="laporan_transaksi.php">Laporan Transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        Hello, <?= $_SESSION["nama_admin"]; ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalLogout">Sign out</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Modal -->
            <div class="modal fade" id="modalLogout" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLogoutLabel">Logout?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin logout?
                        </div>
                        <div class="modal-footer">
                            <form action="logout.php" method="get">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- END Header -->