-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Agu 2021 pada 17.48
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbadmin`
--

CREATE TABLE `tbadmin` (
  `id_admin` int(5) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbadmin`
--

INSERT INTO `tbadmin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'ISNANI', 'Isnani', '$2y$10$EqNu.k7Oh8/ChDru/.tCzu7XfugKrh5uXm6rZCf8lg8b7apRhu6Im');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbanggota`
--

CREATE TABLE `tbanggota` (
  `id_anggota` varchar(5) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `gender` enum('Pria','Wanita') NOT NULL,
  `alamat` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `foto` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbanggota`
--

INSERT INTO `tbanggota` (`id_anggota`, `nama`, `gender`, `alamat`, `status`, `foto`) VALUES
('001', 'Rifnatul ', 'Wanita', 'Krunggeukuh', 'Meminjam', '001.jpg'),
('002', 'sarhan', 'Pria', 'Lhokseumawe\r\n', 'Tidak Meminjam', '002.jpg'),
('A003', 'Isnani', 'Wanita', 'Lhokseumawe,Aceh', 'Tidak Meminjam', 'A003.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbbuku`
--

CREATE TABLE `tbbuku` (
  `id_buku` varchar(5) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tahun` int(4) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbbuku`
--

INSERT INTO `tbbuku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `kategori`, `tahun`, `foto`) VALUES
('0001', 'Konsep Dasar Sistem Pakar', 'Muhammad Arhami', '-', 'Programming', 2017, 'B001.jpg'),
('0002', 'Data Maining', 'Muhammad Arhami', '-', 'Programming', 2019, 'B002.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpeminjam`
--

CREATE TABLE `tbpeminjam` (
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` varchar(5) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `id_anggota` varchar(5) NOT NULL,
  `id_petugas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpengembalian`
--

CREATE TABLE `tbpengembalian` (
  `id_pengembalian` int(5) NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int(11) NOT NULL,
  `id_buku` varchar(5) NOT NULL,
  `id_anggota` varchar(5) NOT NULL,
  `id_petugas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbadmin`
--
ALTER TABLE `tbadmin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tbanggota`
--
ALTER TABLE `tbanggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `tbbuku`
--
ALTER TABLE `tbbuku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `tbpeminjam`
--
ALTER TABLE `tbpeminjam`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- Indeks untuk tabel `tbpengembalian`
--
ALTER TABLE `tbpengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbadmin`
--
ALTER TABLE `tbadmin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbpeminjam`
--
ALTER TABLE `tbpeminjam`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbpengembalian`
--
ALTER TABLE `tbpengembalian`
  MODIFY `id_pengembalian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbpeminjam`
--
ALTER TABLE `tbpeminjam`
  ADD CONSTRAINT `tbpeminjam_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `tbbuku` (`id_buku`),
  ADD CONSTRAINT `tbpeminjam_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `tbadmin` (`id_admin`),
  ADD CONSTRAINT `tbpeminjam_ibfk_3` FOREIGN KEY (`id_anggota`) REFERENCES `tbanggota` (`id_anggota`);

--
-- Ketidakleluasaan untuk tabel `tbpengembalian`
--
ALTER TABLE `tbpengembalian`
  ADD CONSTRAINT `tbpengembalian_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tbanggota` (`id_anggota`),
  ADD CONSTRAINT `tbpengembalian_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tbbuku` (`id_buku`),
  ADD CONSTRAINT `tbpengembalian_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `tbadmin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
