-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 23 Nov 2022 pada 15.23
-- Versi server: 5.6.38
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelasku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `nama_kelas` varchar(120) NOT NULL,
  `tentang` varchar(1000) DEFAULT NULL,
  `hasAkses` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0>Menunggu,Aktif, ditolak',
  `dibuat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `creator_id`, `nama_kelas`, `tentang`, `hasAkses`, `status`, `dibuat`) VALUES
(1, 4, 'Desain Grafis', NULL, 1, 1, '2127523338'),
(3, 1, 'Programing', 'https://google.co.id', 0, 1, '2127523338'),
(4, 4, 'Youtuber', 'https://google.co.in', 0, 1, '1665704173'),
(5, 4, 'Pengairan', NULL, 0, 1, '1666361277'),
(6, 1, 'Fisika Kuantum', NULL, 0, 0, '1668767927');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_user`
--

CREATE TABLE `kelas_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `status_kelas` tinyint(4) NOT NULL,
  `bergabung` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kelas_user`
--

INSERT INTO `kelas_user` (`id`, `id_user`, `id_kelas`, `creator_id`, `status_kelas`, `bergabung`) VALUES
(13, 9, 3, 0, 0, '1665658120'),
(15, 5, 3, 0, 0, '1666699102'),
(18, 5, 1, 0, 0, '1667553253');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kode_undangan`
--

CREATE TABLE `kode_undangan` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL DEFAULT '-1',
  `uid` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `kuota` int(11) NOT NULL,
  `dipakai` int(11) NOT NULL DEFAULT '0',
  `exp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kode_undangan`
--

INSERT INTO `kode_undangan` (`id`, `id_kelas`, `uid`, `label`, `kode`, `kuota`, `dipakai`, `exp`) VALUES
(1, 4, 4, 'Test test', '157JLK', 1, 0, 1667044762),
(2, -1, 1, 'Gelombang 1', 'uVXlt0', 3, 0, 1666950820),
(3, 1, 4, 'Ujs', 'agkLoe', 3, 2, 1668417110);

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi_kelas`
--

CREATE TABLE `materi_kelas` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `teks` varchar(1000) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `youtube` varchar(120) DEFAULT NULL,
  `judul` varchar(100) NOT NULL,
  `foto` varchar(1000) DEFAULT NULL,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `materi_kelas`
--

INSERT INTO `materi_kelas` (`id`, `id_kelas`, `teks`, `link`, `youtube`, `judul`, `foto`, `views`, `waktu`) VALUES
(1, 1, 'Ini test mode hanya teks\r\nTest auto enter\r\n\r\nAbcd', NULL, NULL, 'Test Materi 1', NULL, 63, 1666102936),
(2, 1, NULL, NULL, 'gUBu3U8DBzo', 'Tes embed youtube', NULL, 67, 1666104558),
(3, 1, NULL, '[{\"name\":\"https://www.w3schools.com\",\"url\":\"https://www.w3schools.com\"},{\"name\":\"W3schools\",\"url\":\"https://www.w3schools.com/jsrEF/jsref_trim_string.asp\"}]', NULL, 'Tes materi hanya link', NULL, 21, 1666139673),
(4, 1, NULL, NULL, NULL, 'Test materi gambar', 'http://localhost:8999/assets/img/uploads/a8eab50830aed01c22e589c937667102.jpg', 6, 1666178684);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_sidebar`
--

CREATE TABLE `menu_sidebar` (
  `id_menu` int(11) NOT NULL,
  `role_id` enum('admin','guru','all') NOT NULL,
  `title` varchar(20) NOT NULL,
  `icon` varchar(32) NOT NULL,
  `href` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `menu_sidebar`
--

INSERT INTO `menu_sidebar` (`id_menu`, `role_id`, `title`, `icon`, `href`, `position`) VALUES
(0, 'all', 'Kelas', 'fa fa-graduation-cap', '/dashboard/kelas', 2),
(1, 'all', 'Dashboard', 'fa fa-tachometer', '/dashboard', 1),
(3, 'admin', 'Users', 'fa fa-users', '/dashboard/users', 6),
(4, 'all', 'Siswa', 'fa fa-user', '/dashboard/siswa', 4),
(5, 'all', 'Materi', 'fa fa-book', '/dashboard/materi', 3),
(6, 'admin', 'Kelola Kelas', 'fa fa-graduation-cap', '/dashboard/kelola_kelas', 7),
(7, 'all', 'Kode Undangan', 'fa fa-lock', '/dashboard/invite', 5),
(8, 'admin', 'Kelola Link', 'fa fa-link', '/dashboard/manage_link', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `notes`
--

INSERT INTO `notes` (`id`, `user`, `title`, `text`, `time`) VALUES
(2, 1, 'Ini judul catatan 2', 'This blog does not share personal information with third parties nor do we store any information about your visit to this blog other than to analyze and optimize your content and reading experience through the use of cookies.\n\nYou can turn off the use of cookies at any time by changing your specific browser settings.\n', 1669041140),
(3, 1, 'Lorem ipsum', 'Kakak bisa hubungi saya gatot subroto\n', 1669041067),
(4, 5, 'Hhh', 'Bbb bhhhh\n', 1669069695),
(5, 1, 'Vvvv', 'Ggvvv\n', 1669128805),
(6, 5, 'Hahah', 'Wgwhhwh sjhshsjs\n', 1669131085),
(7, 5, 'Kekiekw wuuw', 'Qhuwuwhww\n', 1669131323);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `target` enum('all','admin','guru','siswa') NOT NULL,
  `user` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `isRead` tinyint(4) NOT NULL DEFAULT '0',
  `icon` varchar(20) NOT NULL DEFAULT 'fa fa-bell-o',
  `type` enum('info','error','success','warning') NOT NULL DEFAULT 'info',
  `time` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `target`, `user`, `title`, `content`, `isRead`, `icon`, `type`, `time`) VALUES
(2, 'all', 4, 'Selamat Datang Semua!', 'Hallo semuanya ini pesan dari admin', 0, 'fa fa-bell-o', 'info', 1667552323),
(3, 'guru', -1, 'Selamat Datang guru!', 'Hallo semuanya ini pesan dari admin', 0, 'fa fa-bell-o', 'info', 1667552323),
(4, 'all', 4, 'Siswa Baru [Desain Grafis]', '@user1 telah bergabung ke kelas anda', 1, 'fa fa-user-plus', 'warning', 1667553253);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `fullname` varchar(120) DEFAULT NULL,
  `foto` varchar(512) DEFAULT NULL,
  `kelamin` enum('Pria','Wanita') NOT NULL DEFAULT 'Pria',
  `whatsapp` varchar(15) DEFAULT NULL,
  `kelas` varchar(100) NOT NULL DEFAULT '[]',
  `tgl_lahir` bigint(20) NOT NULL,
  `rekening` varchar(1000) DEFAULT NULL,
  `regTime` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id`, `uid`, `fullname`, `foto`, `kelamin`, `whatsapp`, `kelas`, `tgl_lahir`, `rekening`, `regTime`) VALUES
(1, 5, 'Siswa Pertama', '/assets/img/avatar/c3a4bae0866aeefef69576d8e64a839a.jpg', 'Pria', '62853257865', '[3,1]', 1236877200, 'Tas', 0),
(2, 9, 'Hendi Pranata', '/assets/img/default-siswa.png', 'Pria', '6285603978589', '[3]', 0, NULL, 1665058279),
(3, 4, 'Helmizar A', '/assets/img/default-guru.png', 'Pria', '628768908765', '[]', 0, NULL, 1665058279),
(4, 1, 'Admin Satu', '/assets/img/default-guru.png', 'Pria', '628768908765', '[]', 970246800, 'Anu ana ene ono', 1665058279);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `user_id`, `created`) VALUES
(1, '45a8f3c28ddbbe610cf3747c9eaa61', 9, '2022-10-07'),
(2, 'db23a57b8e8f3a252d7a08a38f9342', 9, '2022-10-07'),
(3, '7164025bffcc68e174811ca39b673f', 9, '2022-10-07'),
(4, '04e2178d9b8aedecae39c798002d1d', 9, '2022-10-07'),
(5, '5a4ff0f63de684c76bcf001faca942', 9, '2022-10-07'),
(6, '79d291e90608a755233986a15c4e7f', 9, '2022-10-07'),
(7, '1a7e502f64d04a6ccd41f72ffd1769', 9, '2022-11-01'),
(8, 'e47cd96b378fdd76d91b3439f25002', 9, '2022-11-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` int(1) NOT NULL DEFAULT '1',
  `isActive` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `token` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabel Admin dan Guru';

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role_id`, `isActive`, `status`, `token`) VALUES
(1, 'admin', 'example2@gmail.com', '$2y$10$jojzlWLc4CuG1nBfuXa0FuOcNqwFIryNUOq.vH3dBGi1PwjFgbCCm', 0, 1, 1, 'cceed845-3cdb-11ed-bad6-51177f379855'),
(4, 'guru1', 'example@mail.com', '$2y$10$jojzlWLc4CuG1nBfuXa0FuOcNqwFIryNUOq.vH3dBGi1PwjFgbCCm', 1, 1, 1, '27921902148255744'),
(5, 'user1', 'example@mail.com', '$2y$10$jojzlWLc4CuG1nBfuXa0FuOcNqwFIryNUOq.vH3dBGi1PwjFgbCCm', 2, 1, 1, '27921902148255745'),
(9, 'ilham5', 'ilhamsense8@gmail.com', '$2y$10$yFqxjZIglAItkQFIG5YYKer.ks6AGYIr233kDdy37HFrMW.Vmsd9i', 2, 0, 0, '73c3a769-2584-4fc7-9687-82528ed625c0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_online`
--

CREATE TABLE `user_online` (
  `id` bigint(200) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `time` int(11) NOT NULL,
  `location` varchar(50) NOT NULL,
  `browser` varchar(250) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_online`
--

INSERT INTO `user_online` (`id`, `uid`, `ip`, `time`, `location`, `browser`, `role`) VALUES
(39, 1, '::1', 1669191776, 'http://localhost:8999/dashboard', 'Mozilla/5.0 (Linux; Android 10; M2006C3MG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Mobile Safari/537.36', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `guru_kelas` (`creator_id`);

--
-- Indeks untuk tabel `kelas_user`
--
ALTER TABLE `kelas_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Anu` (`id_kelas`),
  ADD KEY `Ke Siswa` (`id_user`);

--
-- Indeks untuk tabel `kode_undangan`
--
ALTER TABLE `kode_undangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `materi_kelas`
--
ALTER TABLE `materi_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Join Ke Kelas` (`id_kelas`);

--
-- Indeks untuk tabel `menu_sidebar`
--
ALTER TABLE `menu_sidebar`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indeks untuk tabel `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `user_online`
--
ALTER TABLE `user_online`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kelas_user`
--
ALTER TABLE `kelas_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `kode_undangan`
--
ALTER TABLE `kode_undangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `materi_kelas`
--
ALTER TABLE `materi_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `menu_sidebar`
--
ALTER TABLE `menu_sidebar`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_online`
--
ALTER TABLE `user_online`
  MODIFY `id` bigint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas_user`
--
ALTER TABLE `kelas_user`
  ADD CONSTRAINT `Anu` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ke Siswa` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materi_kelas`
--
ALTER TABLE `materi_kelas`
  ADD CONSTRAINT `Join Ke Kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_online`
--
ALTER TABLE `user_online`
  ADD CONSTRAINT `user_online_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
