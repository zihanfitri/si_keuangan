-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Okt 2024 pada 05.49
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_keuangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `catering`
--

CREATE TABLE `catering` (
  `id` int(11) NOT NULL,
  `id_siswa` smallint(6) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `waktu` date NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `catering`
--

INSERT INTO `catering` (`id`, `id_siswa`, `nominal`, `tanggal`, `waktu`, `time`) VALUES
(1, 3, '15000', '2019-12-18 10:11:30', '2019-11-08', '2019-11-17'),
(2, 2, '15000', '2019-11-16 20:48:15', '2019-11-09', '2019-11-17'),
(3, 2, '15000', '2019-11-16 20:48:15', '2019-11-11', '2019-11-17'),
(4, 9, '15000', '2019-12-04 07:55:13', '2019-12-04', '2019-12-04'),
(5, 9, '15000', '2019-12-04 07:55:13', '2019-12-05', '2019-12-04'),
(6, 9, '0', '2019-12-18 10:40:36', '2019-12-06', '2019-12-04'),
(7, 9, '15000', '2019-12-04 07:55:13', '2019-12-07', '2019-12-04'),
(9, 9, '15000', '2019-12-04 08:04:39', '2019-12-27', '2019-12-04'),
(10, 9, '15000', '2019-12-04 08:04:39', '2019-12-28', '2019-12-04'),
(11, 9, '15000', '2019-12-04 08:04:39', '2019-12-30', '2019-12-04'),
(12, 8, '15000', '2019-12-04 08:07:48', '2019-12-12', '2019-12-04'),
(13, 8, '15000', '2019-12-04 08:07:48', '2019-12-13', '2019-12-04'),
(14, 8, '15000', '2019-12-04 08:07:48', '2019-12-14', '2019-12-04'),
(15, 8, '15000', '2019-12-04 08:08:51', '2019-12-26', '2019-12-04'),
(16, 8, '15000', '2019-12-04 08:08:51', '2019-12-30', '2019-12-04'),
(17, 8, '0', '2019-12-18 10:25:52', '2019-12-31', '2019-12-04'),
(18, 8, '15000', '2019-12-18 09:15:55', '2019-12-19', '2019-12-18'),
(19, 8, '15000', '2019-12-18 09:15:55', '2019-12-23', '2019-12-18'),
(20, 8, '15000', '2019-12-18 09:15:55', '2019-12-24', '2019-12-18'),
(21, 8, '15000', '2019-12-18 09:15:55', '2019-12-25', '2019-12-18'),
(22, 8, '15000', '2019-12-18 09:15:55', '2020-01-01', '2019-12-18'),
(23, 8, '15000', '2019-12-18 09:15:55', '2020-01-02', '2019-12-18'),
(24, 8, '15000', '2019-12-18 09:15:55', '2020-01-06', '2019-12-18'),
(25, 8, '15000', '2019-12-18 09:15:55', '2020-01-07', '2019-12-18'),
(26, 8, '15000', '2019-12-18 09:15:55', '2020-01-08', '2019-12-18'),
(27, 8, '15000', '2019-12-18 09:15:55', '2020-01-09', '2019-12-18'),
(28, 12, '0', '2022-09-19 15:22:01', '2022-09-19', '2022-09-19'),
(29, 12, '15000', '2022-09-19 15:16:24', '2022-09-20', '2022-09-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gaji`
--

CREATE TABLE `gaji` (
  `id` int(11) NOT NULL,
  `id_guru` tinyint(4) NOT NULL,
  `periode` varchar(20) NOT NULL,
  `jam` varchar(4) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `time` date NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gaji`
--

INSERT INTO `gaji` (`id`, `id_guru`, `periode`, `jam`, `nominal`, `time`, `tanggal`) VALUES
(1, 3, 'Januari-2024', '24', '40000', '2024-09-30', '2024-09-30 13:10:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sex` enum('Pria','Wanita') NOT NULL,
  `nip` varchar(15) NOT NULL,
  `bidang` varchar(40) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `status` enum('Berhenti','Cuti','Aktif') NOT NULL,
  `number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `name`, `sex`, `nip`, `bidang`, `alamat`, `status`, `number`) VALUES
(3, 'Baharuddin', 'Pria', '1201200221', 'Matimatika', 'Jln Kenangan', 'Aktif', '0853-8833-2311'),
(4, 'Rismasuci', 'Wanita', '02130001231', 'Bahasa Indonesia', 'Jl. Kelapa dua', 'Aktif', '0852-9992-1212');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jajan`
--

CREATE TABLE `jajan` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jajan`
--

INSERT INTO `jajan` (`id`, `id_siswa`, `tanggal`, `masuk`, `keluar`, `saldo`, `keterangan`) VALUES
(1, 13, '2024-09-30', 500000, 0, 500000, ''),
(2, 13, '2024-09-30', 0, 50000, 450000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(15) NOT NULL,
  `wali` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `wali`, `keterangan`) VALUES
(5, 'Kelas 1A', 'Baharuddin', ''),
(6, 'Kelas 1B', 'Rismasuci', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lainnya`
--

CREATE TABLE `lainnya` (
  `id` int(11) NOT NULL,
  `sekarang` varchar(15) NOT NULL,
  `time` date NOT NULL,
  `jenis` varchar(64) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `lainnya`
--

INSERT INTO `lainnya` (`id`, `sekarang`, `time`, `jenis`, `keterangan`, `nominal`, `tanggal`) VALUES
(1, '240930', '2024-09-30', 'Sumbangan', 'Sumbangan dari Hamba Allah', '5000000', '2024-09-30 13:11:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `saldo_awal` varchar(15) NOT NULL DEFAULT '0',
  `kas_masuk` varchar(15) DEFAULT '0',
  `kas_keluar` varchar(15) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `saldo_awal`, `kas_masuk`, `kas_keluar`, `tanggal`) VALUES
(13, '0', '5770000', '1060000', '2024-09-30'),
(22, '4710000', '70000', '200000', '2024-10-01'),
(23, '4580000', '0', '0', '2024-10-03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `tipe` enum('KM','KK') NOT NULL,
  `kode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `nama`, `nominal`, `tipe`, `kode`) VALUES
(1, 'Uang SPP', '70000', 'KM', 'KM-0001'),
(6, 'Pembayaran Gaji', '40000', 'KK', 'KK-0001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `time` date NOT NULL,
  `siswa` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `sekarang` varchar(10) NOT NULL,
  `time` date NOT NULL,
  `jenis` varchar(64) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `nominal`, `sekarang`, `time`, `jenis`, `keterangan`, `tanggal`) VALUES
(1, '100000', '240930', '2024-09-30', 'ATK', 'Kertas HVS', '2024-09-30 13:14:53'),
(2, '200000', '241001', '2024-10-01', 'Operasional', 'Beli kayu', '2024-10-01 01:33:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `sex` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `status` enum('Berhenti','Cuti','Aktif') NOT NULL,
  `wali` varchar(50) NOT NULL,
  `tempat` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kelas` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `name`, `nis`, `sex`, `status`, `wali`, `tempat`, `tanggal`, `alamat`, `kelas`) VALUES
(10, 'Suci Permata Sari', '123313134223', 'Perempuan', 'Aktif', 'Musa Harun', 'Kampar', '2020-02-17', 'Jl. Simpang Lima', 6),
(11, 'Ahmad Dhairobbi', '1231314331', 'Laki-laki', 'Aktif', 'Darmijan', 'Batu Guntung', '2002-07-25', 'Jln Kebakyoran Baru', 5),
(12, 'Andrew Benedictus Jamesie', '01234567', 'Laki-laki', 'Cuti', 'Darmijan', 'Medan', '2003-01-20', 'Jl. Dr. Mansyur', 5),
(13, 'Ucok Bambang', '76543210', 'Laki-laki', 'Berhenti', 'Darmijan', 'Medan', '2001-01-01', 'Jl. Bambang', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `snack`
--

CREATE TABLE `snack` (
  `id` int(11) NOT NULL,
  `id_siswa` smallint(6) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time` date NOT NULL,
  `waktu` date NOT NULL,
  `nominal` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `spp`
--

CREATE TABLE `spp` (
  `id` int(11) NOT NULL,
  `id_siswa` smallint(6) NOT NULL,
  `time` date NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `nominal` varchar(12) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `spp`
--

INSERT INTO `spp` (`id`, `id_siswa`, `time`, `bulan`, `nominal`, `tanggal`) VALUES
(1, 11, '2024-09-30', 'Januari-2024', '70000', '2024-09-30 13:05:17'),
(2, 11, '2024-09-30', 'Februari-2024', '70000', '2024-09-30 13:05:23'),
(3, 11, '2024-09-30', 'Maret-2024', '70000', '2024-09-30 13:05:28'),
(4, 12, '2024-09-30', 'Januari-2024', '70000', '2024-09-30 13:09:58'),
(5, 12, '2024-09-30', 'Februari-2024', '70000', '2024-09-30 13:10:32'),
(6, 10, '2024-09-30', 'Januari-2024', '70000', '2024-09-30 13:21:01'),
(7, 13, '2024-09-30', 'Januari-2024', '70000', '2024-09-30 13:21:36'),
(8, 11, '2024-09-30', 'Mei-2024', '70000', '2024-09-30 13:36:27'),
(9, 11, '2024-09-30', 'April-2024', '70000', '2024-09-30 14:14:11'),
(10, 12, '2024-09-30', 'April-2024', '70000', '2024-09-30 14:15:14'),
(11, 10, '2024-09-30', 'April-2024', '70000', '2024-09-30 14:15:26'),
(12, 11, '2024-10-01', 'Agustus-2024', '70000', '2024-10-01 01:28:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id`, `id_siswa`, `nominal`, `tanggal`, `status`, `saldo`) VALUES
(1, 13, 50000, '2024-09-30 00:00:00', 1, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanggal`
--

CREATE TABLE `tanggal` (
  `id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `Keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tanggal`
--

INSERT INTO `tanggal` (`id`, `tgl`, `Keterangan`) VALUES
(3, '2020-06-01', 'Hari Pancasila'),
(4, '2020-05-22', 'Hari Buruh');

-- --------------------------------------------------------

--
-- Struktur dari tabel `temp`
--

CREATE TABLE `temp` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `tempat` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `wali` varchar(100) NOT NULL,
  `sex` enum('Pria','Wanita') NOT NULL,
  `status` enum('Non-Aktif','Aktif') NOT NULL,
  `kelas` tinyint(4) NOT NULL,
  `bayar` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `id_siswa` smallint(6) NOT NULL,
  `nominal` varchar(15) NOT NULL,
  `periode` varchar(20) NOT NULL,
  `time` date NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  `active` enum('1','0') NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`, `active`, `gambar`, `created_on`) VALUES
(1, 'harumsentosa@gmail.com', '$2y$10$dFdQaba34BplJRnmCv54/uhoFLU0wlXCY4lRG/EG9FpX9fN1kzjq.', 'Harum Sentosa Baru', 1, '1', 'logo_harum_sentosa_baru.png', '2022-09-18 10:03:50'),
(3, 'admin123@gmail.com', '$2y$10$KmTNhCy0tO31/E2nF4g36Oh8g2RMxPTcDNdWZWUwxOpMHPuvTw4AC', 'Administrator', 2, '1', 'logo_al_muhajirin.png', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `catering`
--
ALTER TABLE `catering`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gaji`
--
ALTER TABLE `gaji`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jajan`
--
ALTER TABLE `jajan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lainnya`
--
ALTER TABLE `lainnya`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `snack`
--
ALTER TABLE `snack`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tanggal`
--
ALTER TABLE `tanggal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `catering`
--
ALTER TABLE `catering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `gaji`
--
ALTER TABLE `gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jajan`
--
ALTER TABLE `jajan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `lainnya`
--
ALTER TABLE `lainnya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `snack`
--
ALTER TABLE `snack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `spp`
--
ALTER TABLE `spp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tanggal`
--
ALTER TABLE `tanggal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `temp`
--
ALTER TABLE `temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
