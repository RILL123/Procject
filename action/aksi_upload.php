<?php
include 'koneksi.php';
$msg = '';

function uploadAnime($koneksi) {
    $judul = trim($_POST['judul'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $coverName = '';
    $episodeNames = [];
    // Upload cover image
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $coverName = basename($_FILES['foto']['name']);
        $coverTarget = '../image/' . $coverName;
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $coverTarget)) {
            return '<div class="text-red-600 mb-4">Gagal upload cover!</div>';
        }
    }
    // Buat folder video jika belum ada
    $videoFolder = '../video/' . $judul;
    if (!is_dir($videoFolder)) {
        mkdir($videoFolder, 0777, true);
    }
    // Upload episode files
    if (isset($_FILES['episode']) && is_array($_FILES['episode']['name'])) {
        foreach ($_FILES['episode']['name'] as $idx => $epName) {
            if ($_FILES['episode']['error'][$idx] === UPLOAD_ERR_OK) {
                $epBase = basename($epName);
                $epTarget = $videoFolder . '/' . $epBase;
                if (move_uploaded_file($_FILES['episode']['tmp_name'][$idx], $epTarget)) {
                    $episodeNames[] = $epBase;
                }
            }
        }
    }
    // Insert ke database
    if ($judul && $coverName) {
        $genre = trim($_POST['genre'] ?? '');
        $judulEsc = mysqli_real_escape_string($koneksi, $judul);
        $descEsc = mysqli_real_escape_string($koneksi, $deskripsi);
        $ratingEsc = mysqli_real_escape_string($koneksi, $rating);
        $coverEsc = mysqli_real_escape_string($koneksi, $coverName);
        $genreEsc = mysqli_real_escape_string($koneksi, $genre);
        $sql = "INSERT INTO anime (judul_anime, synopsis, rating, image, genre) VALUES ('$judulEsc', '$descEsc', '$ratingEsc', '$coverEsc', '$genreEsc')";
        if (mysqli_query($koneksi, $sql)) {
            return '<div class="text-green-600 mb-4">Anime berhasil ditambahkan!</div>';
        } else {
            return '<div class="text-red-600 mb-4">Gagal tambah ke database: ' . mysqli_error($koneksi) . '</div>';
        }
    } else {
        return '<div class="text-red-600 mb-4">Judul dan cover wajib diisi!</div>';
    }
}

function uploadManga($koneksi) {
    $judul = trim($_POST['judul_manga'] ?? '');
    $genre = trim($_POST['genre_manga'] ?? '');
    $synopsis = trim($_POST['synopsis_manga'] ?? '');
    $rating = trim($_POST['rating_manga'] ?? '');
    $coverName = '';
    $volumeName = '';
    // Upload cover
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $coverName = basename($_FILES['cover']['name']);
        $coverTarget = '../image/' . $coverName;
        if (!move_uploaded_file($_FILES['cover']['tmp_name'], $coverTarget)) {
            return '<div class="text-red-600 mb-4">Gagal upload cover manga!</div>';
        }
    }
    // Buat folder manga jika belum ada
    $mangaFolder = '../manga/';
    if (!is_dir($mangaFolder)) {
        mkdir($mangaFolder, 0777, true);
    }
    // Upload chapter (PDF/ZIP)
    if (isset($_FILES['chapter']) && $_FILES['chapter']['error'] === UPLOAD_ERR_OK) {
        $chapterName = basename($_FILES['chapter']['name']);
        $chapterTarget = $mangaFolder . $chapterName;
        if (!move_uploaded_file($_FILES['chapter']['tmp_name'], $chapterTarget)) {
            return '<div class="text-red-600 mb-4">Gagal upload chapter manga!</div>';
        }
    }
    // Insert ke database manga
    if ($judul && $coverName && $chapterName) {
        $judulEsc = mysqli_real_escape_string($koneksi, $judul);
        $genreEsc = mysqli_real_escape_string($koneksi, $genre);
        $synopsisEsc = mysqli_real_escape_string($koneksi, $synopsis);
        $ratingEsc = mysqli_real_escape_string($koneksi, $rating);
        $coverEsc = mysqli_real_escape_string($koneksi, $coverName);
        $volumeEsc = mysqli_real_escape_string($koneksi, $volumeName);
        $sql = "INSERT INTO manga (judul_manga, genre, synopsis, rating, cover, volume) VALUES ('$judulEsc', '$genreEsc', '$synopsisEsc', '$ratingEsc', '$coverEsc', '$volumeEsc')";
        if (mysqli_query($koneksi, $sql)) {
            return '<div class="text-green-600 mb-4">Manga berhasil ditambahkan!</div>';
        } else {
            return '<div class="text-red-600 mb-4">Gagal tambah manga ke database: ' . mysqli_error($koneksi) . '</div>';
        }
    } else {
        return '<div class="text-red-600 mb-4">Semua field manga wajib diisi!</div>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['judul_manga'])) {
        $msg = uploadManga($koneksi);
    } else {
        $msg = uploadAnime($koneksi);
    }
}
// Untuk feedback ke upload.php
echo $msg;
