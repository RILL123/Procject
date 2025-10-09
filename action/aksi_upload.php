<?php
include 'koneksi.php';
$msg = '';

function uploadAnime($koneksi) {
    $judul = trim($_POST['judul'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $coverName = '';
    $episodeNames = [];
    // Upload cover image -> name the file based on the title
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $orig = basename($_FILES['foto']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safeTitle = preg_replace('/[^a-zA-Z0-9._-]/', '_', $judul);
        $coverName = $safeTitle . ($ext ? ('.' . $ext) : '');
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
            return '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Anime berhasil ditambahkan!</div>';
        } else {
            return '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal tambah ke database: ' . mysqli_error($koneksi) . '</div>';
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
    // Upload cover (accept both 'cover' and 'cover_manga' names)
    if ((isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) || (isset($_FILES['cover_manga']) && $_FILES['cover_manga']['error'] === UPLOAD_ERR_OK)) {
        $coverField = isset($_FILES['cover']) ? 'cover' : 'cover_manga';
        $orig = basename($_FILES[$coverField]['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safeTitle = preg_replace('/[^a-zA-Z0-9._-]/', '_', $judul);
        $coverName = $safeTitle . ($ext ? ('.' . $ext) : '');
        $coverTarget = '../image/' . $coverName;
        if (!move_uploaded_file($_FILES[$coverField]['tmp_name'], $coverTarget)) {
            return '<div class="text-red-600 mb-4">Gagal upload cover manga!</div>';
        }
    }
    // Buat folder per-manga berdasarkan judul
    $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($judul));
    $mangaFolder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
    if (!is_dir($mangaFolder)) {
        mkdir($mangaFolder, 0777, true);
    }
    // Upload chapter (PDF/ZIP) ke folder per-manga
    $chapterName = '';
    if (isset($_FILES['chapter']) && $_FILES['chapter']['error'] === UPLOAD_ERR_OK) {
        $chapterName = basename($_FILES['chapter']['name']);
        $chapterTarget = $mangaFolder . $chapterName;
        if (!move_uploaded_file($_FILES['chapter']['tmp_name'], $chapterTarget)) {
            return '<div class="text-red-600 mb-4">Gagal upload chapter manga!</div>';
        }
        $volumeName = $chapterName; // simpan nama file ke DB volume field (opsional)
    }
    // Insert ke database manga
    if ($judul && $coverName && $chapterName) {
        $judulEsc = mysqli_real_escape_string($koneksi, $judul);
        $genreEsc = mysqli_real_escape_string($koneksi, $genre);
        $synopsisEsc = mysqli_real_escape_string($koneksi, $synopsis);
        $ratingEsc = mysqli_real_escape_string($koneksi, $rating);
        $coverEsc = mysqli_real_escape_string($koneksi, $coverName);
    // Do not include 'volume' column in INSERT (not present in DB schema)
    $sql = "INSERT INTO manga (judul_manga, genre, synopsis, rating, cover) VALUES ('$judulEsc', '$genreEsc', '$synopsisEsc', '$ratingEsc', '$coverEsc')";
        if (mysqli_query($koneksi, $sql)) {
            return '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Manga berhasil ditambahkan!</div>';
        } else {
            return '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal tambah manga ke database: ' . mysqli_error($koneksi) . '</div>';
        }
    } else {
        return '<div class="text-red-600 mb-4">Semua field manga wajib diisi!</div>';
    }
}

function uploadNovel($koneksi) {
    // mirror logic from aksi_upload_novel but return message instead of echoing
    $novelDirRoot = __DIR__ . '/../novel/';
    if (!is_dir($novelDirRoot)) mkdir($novelDirRoot, 0755, true);

    $judul = trim($_POST['judul_novel'] ?? '');
    $genre = trim($_POST['genre_novel'] ?? '');
    $rating = floatval($_POST['rating_novel'] ?? 0);
    $synopsis = trim($_POST['synopsis_novel'] ?? '');

    if (empty($judul)) {
        return '<div class="text-red-600 mb-4">Judul novel wajib diisi.</div>';
    }

    // create table if not exists
    $createSql = "CREATE TABLE IF NOT EXISTS novel (
        id_novel INT AUTO_INCREMENT PRIMARY KEY,
        judul_novel VARCHAR(255) NOT NULL,
        synopsis TEXT,
        rating FLOAT DEFAULT 0,
        genre VARCHAR(255),
        cover VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!mysqli_query($koneksi, $createSql)) {
        return '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal membuat tabel novel: ' . mysqli_error($koneksi) . '</div>';
    }

    // upload cover
    $coverName = '';
    if (isset($_FILES['cover_novel']) && $_FILES['cover_novel']['error'] == 0) {
        $orig = basename($_FILES['cover_novel']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safeTitle = preg_replace('/[^a-zA-Z0-9._-]/', '_', $judul);
        $coverName = $safeTitle . ($ext ? ('.' . $ext) : '');
        $coverTarget = __DIR__ . '/../image/' . $coverName;
        if (!move_uploaded_file($_FILES['cover_novel']['tmp_name'], $coverTarget)) {
            return '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload cover.</div>';
        }
    }

    // insert novel record
    $judulEsc = mysqli_real_escape_string($koneksi, $judul);
    $synopsisEsc = mysqli_real_escape_string($koneksi, $synopsis);
    $genreEsc = mysqli_real_escape_string($koneksi, $genre);
    $coverEsc = mysqli_real_escape_string($koneksi, $coverName);

    $insert = "INSERT INTO novel (judul_novel, synopsis, rating, genre, cover) VALUES ('" . $judulEsc . "', '" . $synopsisEsc . "', " . $rating . ", '" . $genreEsc . "', '" . $coverEsc . "')";
    if (!mysqli_query($koneksi, $insert)) {
        return '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal menyimpan data novel: ' . mysqli_error($koneksi) . '</div>';
    }

    $id_novel = mysqli_insert_id($koneksi);
    $uploadedVolumes = 0;

    // create per-novel folder
    $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($judul));
    $novelTitleDir = $novelDirRoot . ($safeTitle ?: 'untitled') . '/';
    if (!is_dir($novelTitleDir)) mkdir($novelTitleDir, 0755, true);

    // upload volume (previously called volume_novel)
    if (isset($_FILES['volume_novel'])) {
        $files = $_FILES['volume_novel'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== 0) continue;
            $orig = basename($files['name'][$i]);
            $safe = $id_novel . '_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $orig);
            $target = $novelTitleDir . $safe;
            if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                $uploadedVolumes++;
            }
        }
    }

    return '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Novel berhasil ditambahkan. (Cover: ' . ($coverName ? 'ya' : 'tidak') . ', volume diupload: ' . $uploadedVolumes . ')</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['judul_novel'])) {
        $msg = uploadNovel($koneksi);
    } elseif (isset($_POST['judul_manga'])) {
        $msg = uploadManga($koneksi);
    } else {
        $msg = uploadAnime($koneksi);
    }
}


// Untuk feedback ke upload.php
echo $msg;
