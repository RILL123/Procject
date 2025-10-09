-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Okt 2025 pada 08.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nimetv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anime`
--

CREATE TABLE `anime` (
  `id_anime` int(255) NOT NULL,
  `judul_anime` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `rating` double(2,1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anime`
--

INSERT INTO `anime` (`id_anime`, `judul_anime`, `synopsis`, `rating`, `image`, `genre`, `video`) VALUES
(1, 'Bocchi The Rock', 'Yearning to make friends and perform live with a band, lonely and socially anxious Hitori \"Bocchi\" Gotou devotes her time to playing the guitar. On a fateful day, Bocchi meets the outgoing drummer Nijika Ijichi, who invites her to join Kessoku Band.', 9.0, 'bocchi.png', 'Music, Comedy', 'Bocchi The Rock'),
(2, 'Uma Musume', 'Famous racehorses that have left behind worthy legacies, unique as they can be, are reincarnated as horse girls in a parallel world. In this life, they start their journey anew as they continue to race and perhaps relive the success they once lived through.', 8.6, 'Uma Musume.jpg', 'Comedy, Sport, Drama', ''),
(3, 'Kaoruko Waguri', 'A kind and caring student from Kikyo Private Academy who comes from a humble family and enrolled at the academy under a scholarship; she is also shown to excel in her grades, leading her to be regarded highly by her peers. She meets Rintarou at the bakery due to being a regular customer and sees his kindhearted nature rather than his intimidating looks, resulting in her falling in love with him. She is also a glutton and eats much of the pastries at the bakery.', 8.9, 'waguri.jpg', 'Drama, Romance, School', ''),
(21, 'Jujutsu Kaisen', 'Idly indulging in baseless paranormal activities with the Occult Club, high schooler Yuuji Itadori spends his days at either the clubroom or the hospital, where he visits his bedridden grandfather. However, this leisurely lifestyle soon takes a turn for the strange when he unknowingly encounters a cursed item. Triggering a chain of supernatural occurrences, Yuuji finds himself suddenly thrust into the world of Curses—dreadful beings formed from human malice and negativity—after swallowing the said item, revealed to be a finger belonging to the demon Sukuna Ryoumen, the King of Curses.', 8.6, 'Jujutsu+Kaisen+Red+Aka+Coloring+Book.png', 'Comedy, Supranatural, Action', ''),
(22, 'Yuru Camp', 'While the perfect getaway for most girls her age might be a fancy vacation with their loved ones, Rin Shima\'s ideal way of spending her days off is camping alone at the base of Mount Fuji. From pitching her tent to gathering firewood, she has always done everything by herself, and has no plans of leaving her little solitary world.', 8.2, 'yuru.png', 'Slice of life', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga`
--

CREATE TABLE `manga` (
  `id_manga` int(20) NOT NULL,
  `judul_manga` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `rating` double(2,1) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `chapter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manga`
--

INSERT INTO `manga` (`id_manga`, `judul_manga`, `synopsis`, `rating`, `cover`, `genre`, `chapter`) VALUES
(3, 'Midari ni Tsukasete wa Narimasen', 'Tamotsu Sugawara, seorang karyawan yang tidak bisa menolak permintaan apa pun, mendapati dirinya tidak bisa lagi pergi ke kantor dan memutuskan untuk beristirahat sementara di kuil keluarganya. Suatu malam, hantu yang sangat mirip dengan Makoto Hiiragi, seorang mahasiswi yang bekerja part time di kuil itu pada siang hari, muncul di hadapannya. Komedi romantis yang terinspirasi dari horor ini menghubungkan mantan karyawan yang ngga bisa bilang tidak (yes-man) dengan mahasiswi yang dicurigai sebagai arwah hidup', 6.9, 'Midari ni Tsukasete wa Narimasen.png', 'Romance, Comedy, Supernatural', ''),
(5, 'Eiyuu to Kenja no Tensei Kon ~Katsute no Koutekishu to Kon\'yakushite Saikyou Fuufu ni Narimashita~', 'Reid, pahlawan muda dengan kekuatan fisik terkuat, dan Elria, seorang bijak cantik dengan kekuatan sihir terkuat. Mereka terus bertarung sebagai rival di negara musuh, namun hubungan mereka berakhir dengan kematian mendadak Elria… Lalu, seribu tahun kemudian, Bereinkarnasi di dunia di mana sihir berkuasa, tapi dia yang mempertahankan kekuatan fisik terkuat dari kehidupan sebelumnya, Reid, bertemu kembali dengan Elria, yang juga telah bereinkarnasi― “Hei, Reid— aku ingin kamu menikah denganku.” \"…Hah?\" Keduanya, yang telah menjadi pasangan mesra terkuat yang tidak disadari dalam seribu tahun, mendaftar di Royal Magic Academy untuk memutuskan siapa yang lebih kuat!', 7.8, '69b3df44-d1d3-4425-a935-0ec7e708391b.jpg.512.png', 'Romance, Fantasy, Reinkarnasi', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id_news` int(11) NOT NULL,
  `caption` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `novel`
--

CREATE TABLE `novel` (
  `id_novel` int(255) NOT NULL,
  `judul_novel` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `rating` double(2,1) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `novel`
--

INSERT INTO `novel` (`id_novel`, `judul_novel`, `synopsis`, `rating`, `cover`, `genre`, `volume`) VALUES
(2, 'Shibou End o Kaihi Shita Galge no heroína-tachi ga Ore no Nikki-chou', 'Seorang siswa yang menyendiri dan tidak tertarik cinta, dia selalu sendirian mau itu pelajaran atau pun melakukan aktifitas, karena dia selalu berfikir jika dia selalu merepotkan oranglain. tetapi suatu hari dia memutuskan untuk membantu siswa laki laki, dan siapa sangka apa yang terjadi selanjutnya.', 6.9, 'Shibou_End_o_Kaihi_Shita_Galge_no_hero__na-tachi_ga_Ore_no_Nikki-chou.png', 'Romance, Shcool', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('pengguna','admin') NOT NULL,
  `pfp` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `bio` tinytext DEFAULT NULL,
  `fav` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `level`, `pfp`, `banner`, `bio`, `fav`) VALUES
(1, 'sahril', 'syahril', '123456', 'pengguna', 'profile_syahril.png', 'banner_syahril.png', 'Yo wassup', NULL),
(4, 'syahril', 'admin', '123456', 'admin', 'profile_admin.png', 'banner_admin.jpeg', NULL, NULL),
(6, 'rizky_Sad564', 'rizky', '123456', 'pengguna', 'profile_rizky.png', 'banner_rizky.jpg', 'Im happy :)\r\n', NULL),
(7, 'edi_Dingin777', 'edi', '123456', 'pengguna', 'profile_edi.png', 'banner_edi.jpg', 'Tch.. diam saja kalian', NULL),
(8, 'restu_Demon02118', 'restu', '123456', 'pengguna', 'profile_restu.jpg', 'banner_restu.jpg', 'tch.. manusia biasa hanya merepotkan...', NULL),
(9, 'Fira', 'Fira', '123456', 'pengguna', 'profile_Fira.jpg', 'banner_Fira.jpg', 'Hi!!!', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`id_anime`);

--
-- Indeks untuk tabel `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id_manga`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id_news`);

--
-- Indeks untuk tabel `novel`
--
ALTER TABLE `novel`
  ADD PRIMARY KEY (`id_novel`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anime`
--
ALTER TABLE `anime`
  MODIFY `id_anime` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `manga`
--
ALTER TABLE `manga`
  MODIFY `id_manga` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id_news` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `novel`
--
ALTER TABLE `novel`
  MODIFY `id_novel` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
