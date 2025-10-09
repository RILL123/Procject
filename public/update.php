
<?php
session_start();
include '../action/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'anime';
$msg = '';
$anime = null;
$episodes = [];
// Manga variables
$manga = null;
$chapters = [];
// Novel variables
$novel = null;
$volumes = [];
// $manga = null; // sudah tidak dipakai
// Fungsi untuk update data anime
function updateAnime($koneksi, $id, &$msg, &$anime) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $rating = floatval($_POST['rating']);
    $synopsis = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $sql = "UPDATE anime SET judul_anime='$judul', genre='$genre', rating='$rating', synopsis='$synopsis' WHERE id_anime=$id";
    if (mysqli_query($koneksi, $sql)) {
        $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Data berhasil diupdate.</div>';
        // Refresh data
        $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id LIMIT 1");
        $anime = mysqli_fetch_assoc($animeQ);
    } else {
        $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal update: ' . mysqli_error($koneksi) . '</div>';
    }
}

// Fungsi untuk update data manga
function updateManga($koneksi, $id, &$msg, &$manga) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul_manga']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre_manga']);
    $rating = floatval($_POST['rating_manga']);
    $synopsis = mysqli_real_escape_string($koneksi, $_POST['synopsis_manga']);
    $sql = "UPDATE manga SET judul_manga='$judul', genre='$genre', rating='$rating', synopsis='$synopsis' WHERE id_manga=$id";
    if (mysqli_query($koneksi, $sql)) {
        $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Data manga berhasil diupdate.</div>';
        // Refresh data
        $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id LIMIT 1");
        $manga = mysqli_fetch_assoc($mangaQ);
    } else {
        $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal update manga: ' . mysqli_error($koneksi) . '</div>';
    }
}

// Fungsi untuk update data novel
function updateNovel($koneksi, $id, &$msg, &$novel) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul_novel']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre_novel']);
    $rating = floatval($_POST['rating_novel']);
    $synopsis = mysqli_real_escape_string($koneksi, $_POST['synopsis_novel']);
    $sql = "UPDATE novel SET judul_novel='$judul', genre='$genre', rating='$rating', synopsis='$synopsis' WHERE id_novel=$id";
    if (mysqli_query($koneksi, $sql)) {
        $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Data novel berhasil diupdate.</div>';
        // Refresh data
        $novelQ = mysqli_query($koneksi, "SELECT * FROM novel WHERE id_novel = $id LIMIT 1");
        $novel = mysqli_fetch_assoc($novelQ);
    } else {
        $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal update novel: ' . mysqli_error($koneksi) . '</div>';
    }
}

// Handler update data (anime / manga / novel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_data'])) {
    if ($tipe === 'anime') {
        updateAnime($koneksi, $id, $msg, $anime);
    } elseif ($tipe === 'manga') {
        updateManga($koneksi, $id, $msg, $manga);
    } elseif ($tipe === 'novel') {
        updateNovel($koneksi, $id, $msg, $novel);
    }
}

// Ambil data sesuai tipe
if ($id > 0) {
    if ($tipe === 'anime') {
        $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id LIMIT 1");
        $anime = mysqli_fetch_assoc($animeQ);
        if ($anime) {
            $folder = '../video/' . $anime['judul_anime'];
            if (is_dir($folder)) {
                $files = scandir($folder);
                foreach ($files as $file) {
                    if (preg_match('/\.(mp4|mkv|avi|mov|flv|webm)$/i', $file)) {
                        $episodes[] = $file;
                    }
                }
            }
        }
    } elseif ($tipe === 'manga') {
        $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id LIMIT 1");
        $manga = mysqli_fetch_assoc($mangaQ);
        if ($manga) {
            $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($manga['judul_manga']));
            $folder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
            if (is_dir($folder)) {
                $files = scandir($folder);
                foreach ($files as $file) {
                    if (preg_match('/\.(pdf|zip)$/i', $file)) {
                        $chapters[] = $file;
                    }
                }
            }
        }
    } elseif ($tipe === 'novel') {
        $novelQ = mysqli_query($koneksi, "SELECT * FROM novel WHERE id_novel = $id LIMIT 1");
        $novel = mysqli_fetch_assoc($novelQ);
        if ($novel) {
            $safeTitleN = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($novel['judul_novel']));
            $folderN = '../novel/' . ($safeTitleN ?: 'untitled') . '/';
            if (is_dir($folderN)) {
                $filesN = scandir($folderN);
                foreach ($filesN as $f) {
                    if (preg_match('/\.(pdf|zip)$/i', $f)) {
                        $volumes[] = $f;
                    }
                }
            }
        }
    }
}


// Proses hapus episode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_episode'])) {
    if ($anime) {
        $folder = '../video/' . $anime['judul_anime'];
        $file = $folder . '/' . basename($_POST['hapus_episode']);
        if (is_file($file)) {
            if (unlink($file)) {
                $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Episode berhasil dihapus.</div>';
            } else {
                $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal hapus episode.</div>';
            }
        }
        // Refresh episode list
        $episodes = [];
        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (preg_match('/\.(mp4|mkv|avi|mov|flv|webm)$/i', $file)) {
                    $episodes[] = $file;
                }
            }
        }
    }
}
// Proses hapus volume (novel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_volume'])) {
    if ($novel) {
        $safeTitleN = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($novel['judul_novel']));
        $folderN = '../novel/' . ($safeTitleN ?: 'untitled') . '/';
        $file = $folderN . '/' . basename($_POST['hapus_volume']);
        if (is_file($file)) {
            if (unlink($file)) {
                $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Volume berhasil dihapus.</div>';
            } else {
                $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal hapus volume.</div>';
            }
        }
        // refresh volumes
        $volumes = [];
        if (is_dir($folderN)) {
            $filesN = scandir($folderN);
            foreach ($filesN as $f) {
                if (preg_match('/\.(pdf|zip)$/i', $f)) $volumes[] = $f;
            }
        }
    }
}
// Proses tambah volume (novel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_volume']) && isset($_FILES['volume_file']) && $_FILES['volume_file']['error'] == 0) {
    if ($novel) {
        $safeTitleN = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($novel['judul_novel']));
        $folderN = '../novel/' . ($safeTitleN ?: 'untitled') . '/';
        if (!is_dir($folderN)) mkdir($folderN, 0777, true);
        $orig = basename($_FILES['volume_file']['name']);
        $targetName = $id . '_' . time() . '_' . $orig;
        $target = $folderN . $targetName;
        if (move_uploaded_file($_FILES['volume_file']['tmp_name'], $target)) {
            $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Volume berhasil diupload.</div>';
        } else {
            $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload volume.</div>';
        }
        // refresh volumes
        $volumes = [];
        if (is_dir($folderN)) {
            $filesN = scandir($folderN);
            foreach ($filesN as $f) {
                if (preg_match('/\.(pdf|zip)$/i', $f)) $volumes[] = $f;
            }
        }
    }
}
// Proses tambah episode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_episode']) && isset($_FILES['episode_file']) && $_FILES['episode_file']['error'] == 0) {
    if ($anime) {
        $folder = '../video/' . $anime['judul_anime'];
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $target = $folder . '/' . basename($_FILES['episode_file']['name']);
        if (move_uploaded_file($_FILES['episode_file']['tmp_name'], $target)) {
            $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Episode berhasil diupload.</div>';
        } else {
            $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload episode.</div>';
        }
        // Refresh episode list
        $episodes = [];
        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (preg_match('/\.(mp4|mkv|avi|mov|flv|webm)$/i', $file)) {
                    $episodes[] = $file;
                }
            }
        }
    }
}
// Proses hapus chapter (manga)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_chapter'])) {
    if ($manga) {
        $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($manga['judul_manga']));
        $folder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
        $file = $folder . '/' . basename($_POST['hapus_chapter']);
        if (is_file($file)) {
            if (unlink($file)) {
                $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Chapter berhasil dihapus.</div>';
            } else {
                $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal hapus chapter.</div>';
            }
        }
        // Refresh chapter list
        $chapters = [];
        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (preg_match('/\.(pdf|zip)$/i', $file)) {
                    $chapters[] = $file;
                }
            }
        }
    }
}
// Proses tambah chapter (manga)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_chapter']) && isset($_FILES['chapter_file']) && $_FILES['chapter_file']['error'] == 0) {
    if ($manga) {
        $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($manga['judul_manga']));
        $folder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $origName = basename($_FILES['chapter_file']['name']);
        $targetName = $id . '_' . time() . '_' . $origName;
        $target = $folder . $targetName;
        if (move_uploaded_file($_FILES['chapter_file']['tmp_name'], $target)) {
            $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Chapter berhasil diupload.</div>';
        } else {
            $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload chapter.</div>';
        }
        // Refresh chapter list
        $chapters = [];
        if (is_dir($folder)) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (preg_match('/\.(pdf|zip)$/i', $file)) {
                    $chapters[] = $file;
                }
            }
        }
    }
}
// Proses update cover manga (handled here to avoid external dependency)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cover_manga']) && isset($_FILES['cover_manga']) && $_FILES['cover_manga']['error'] == 0) {
    if ($manga) {
        $coverDir = '../image/';
        if (!is_dir($coverDir)) mkdir($coverDir, 0777, true);
        $ext = pathinfo($_FILES['cover_manga']['name'], PATHINFO_EXTENSION);
        $newName = 'manga_cover_' . $id . '_' . time() . '.' . $ext;
        $target = $coverDir . $newName;
        if (move_uploaded_file($_FILES['cover_manga']['tmp_name'], $target)) {
            // remove old cover
            if (!empty($manga['cover'])) {
                $old = $coverDir . $manga['cover'];
                if (is_file($old)) unlink($old);
            }
            mysqli_query($koneksi, "UPDATE manga SET cover='" . mysqli_real_escape_string($koneksi, $newName) . "' WHERE id_manga=$id");
            // Refresh data
            $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id LIMIT 1");
            $manga = mysqli_fetch_assoc($mangaQ);
            $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Cover manga berhasil diupdate.</div>';
        } else {
            $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload cover manga.</div>';
        }
    }
}
// Proses update cover novel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cover_novel']) && isset($_FILES['cover_novel']) && $_FILES['cover_novel']['error'] == 0) {
    if ($novel) {
        $coverDir = '../image/';
        if (!is_dir($coverDir)) mkdir($coverDir, 0777, true);
        $ext = pathinfo($_FILES['cover_novel']['name'], PATHINFO_EXTENSION);
        $safeTitleN = preg_replace('/[^a-zA-Z0-9._-]/', '_', trim($novel['judul_novel']));
        $newName = $safeTitleN . ($ext ? ('.' . $ext) : '');
        $target = $coverDir . $newName;
        if (move_uploaded_file($_FILES['cover_novel']['tmp_name'], $target)) {
            if (!empty($novel['cover'])) {
                $old = $coverDir . $novel['cover'];
                if (is_file($old)) unlink($old);
            }
            mysqli_query($koneksi, "UPDATE novel SET cover='" . mysqli_real_escape_string($koneksi, $newName) . "' WHERE id_novel=$id");
            // Refresh data
            $novelQ = mysqli_query($koneksi, "SELECT * FROM novel WHERE id_novel = $id LIMIT 1");
            $novel = mysqli_fetch_assoc($novelQ);
            $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Cover novel berhasil diupdate.</div>';
        } else {
            $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Gagal upload cover novel.</div>';
        }
    }
}
// Proses hapus data (anime/manga)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['id'])) {
    $id_delete = intval($_POST['id']);
    if ($tipe === 'anime') {
        // Ambil data anime
        $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id_delete LIMIT 1");
        $animeDel = mysqli_fetch_assoc($animeQ);
        if ($animeDel) {
            // Hapus cover
            if (!empty($animeDel['image'])) {
                $coverPath = '../image/' . $animeDel['image'];
                if (is_file($coverPath)) {
                    unlink($coverPath);
                }
            }
            // Hapus semua episode
            $folder = '../video/' . $animeDel['judul_anime'];
            if (is_dir($folder)) {
                $files = scandir($folder);
                foreach ($files as $file) {
                    $filePath = $folder . '/' . $file;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
                rmdir($folder);
            }
            // Hapus data dari database
            mysqli_query($koneksi, "DELETE FROM anime WHERE id_anime = $id_delete");
            // Redirect ke halaman admin
            header('Location: admin.php');
            exit;
        }
    } elseif ($tipe === 'manga') {
        // Ambil data manga
        $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id_delete LIMIT 1");
        $mangaDel = mysqli_fetch_assoc($mangaQ);
        if ($mangaDel) {
            // Hapus cover
            if (!empty($mangaDel['cover'])) {
                $coverPath = '../image/' . $mangaDel['cover'];
                if (is_file($coverPath)) {
                    unlink($coverPath);
                }
            }
            // Hapus semua chapters
            $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($mangaDel['judul_manga']));
            $folder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
            if (is_dir($folder)) {
                $files = scandir($folder);
                foreach ($files as $file) {
                    $filePath = $folder . '/' . $file;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
                rmdir($folder);
            }
            // Hapus data dari database
            mysqli_query($koneksi, "DELETE FROM manga WHERE id_manga = $id_delete");
            // Redirect ke halaman admin
            header('Location: admin.php');
            exit;
        }
    } elseif ($tipe === 'novel') {
        // Ambil data novel
        $novelQ = mysqli_query($koneksi, "SELECT * FROM novel WHERE id_novel = $id_delete LIMIT 1");
        $novelDel = mysqli_fetch_assoc($novelQ);
        if ($novelDel) {
            // Hapus cover
            if (!empty($novelDel['cover'])) {
                $coverPath = '../image/' . $novelDel['cover'];
                if (is_file($coverPath)) {
                    unlink($coverPath);
                }
            }
            // Hapus semua volumes
            $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($novelDel['judul_novel']));
            $folder = '../novel/' . ($safeTitle ?: 'untitled') . '/';
            if (is_dir($folder)) {
                $files = scandir($folder);
                foreach ($files as $file) {
                    $filePath = $folder . '/' . $file;
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                }
                rmdir($folder);
            }
            // Hapus data dari database
            mysqli_query($koneksi, "DELETE FROM novel WHERE id_novel = $id_delete");
            // Redirect ke halaman admin
            header('Location: admin.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($tipe === 'manga') ? 'Edit Manga | NimeTV' : 'Edit Anime | NimeTV'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-50 via-white to-purple-100 min-h-screen flex">
    <?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>
    <div class="flex-1 flex flex-col min-h-screen w-full items-center justify-center">
        <div class="w-full max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8 mt-10 border border-indigo-200">
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-8"><?php echo ($tipe === 'manga') ? 'Edit Data Manga' : 'Edit Data Anime'; ?></h1>
            <?php echo $msg; ?>
            <?php if ($tipe === 'anime' && $anime): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8">
                    <!-- Cover di pojok kanan atas -->
                    <div class="md:col-span-1 flex flex-col items-center justify-start">
                        <div class="w-48 h-64 rounded-2xl shadow-xl border-4 border-indigo-200 overflow-hidden mb-4 flex items-center justify-center bg-white">
                            <?php if (!empty($anime['image'])): ?>
                                <img src="../image/<?php echo htmlspecialchars($anime['image']); ?>" class="w-full h-full object-cover" alt="Cover Anime" />
                            <?php else: ?>
                                <span class="text-gray-400 italic">No cover</span>
                            <?php endif; ?>
                        </div>
                        <form action="../action/aksi_update.php" method="POST" enctype="multipart/form-data" class="w-full max-w-xs flex flex-col items-center gap-3 bg-white/80 p-4 rounded-xl shadow">
                            <input type="hidden" name="id" value="<?php echo (int)$anime['id_anime']; ?>">
                            <label class="block text-gray-700 font-semibold mb-2" for="cover">Ganti Cover</label>
                            <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="file" id="cover" name="cover" accept="image/*">
                            <button type="submit" name="update_cover" class="w-full py-2 rounded bg-indigo-500 text-white font-semibold hover:bg-indigo-700 transition-all shadow">Update Cover</button>
                        </form>
                    </div>
                    <!-- Form edit data di samping cover -->
                    <div class="md:col-span-2">
                        <form action="update.php?id=<?php echo $id; ?>" method="POST" class="space-y-8">
                            <input type="hidden" name="id" value="<?php echo (int)$anime['id_anime']; ?>">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="judul">Judul Anime</label>
                                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($anime['judul_anime']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="genre">Genre</label>
                                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($anime['genre']); ?>" required>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="rating">Rating</label>
                                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="number" step="0.1" min="0" max="10" id="rating" name="rating" value="<?php echo htmlspecialchars($anime['rating']); ?>" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Synopsis</label>
                                <textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($anime['synopsis']); ?></textarea>
                            </div>
                            <button type="submit" name="update_data" class="w-full py-3 rounded-full bg-indigo-600 text-white font-bold text-lg shadow hover:bg-indigo-700 transition-all">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Show UI for the selected type only -->
            <?php if ($tipe === 'anime'): ?>
                <?php if ($anime): ?>
                    <?php if (!empty($episodes)) : ?>
                    <div class="mb-4 mt-8">
                        <h3 class="font-bold text-indigo-700 mb-4 text-xl flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zm2 2v6h2V7H6zm4 0v6h2V7h-2z"/></svg>
                            Daftar Episode
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($episodes as $ep): ?>
                                <li class="flex items-center justify-between bg-indigo-100 rounded-lg px-4 py-2 shadow-sm border border-indigo-200">
                                    <span class="font-mono text-indigo-800"><?php echo htmlspecialchars($ep); ?></span>
                                    <form action="update.php?id=<?php echo $id; ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="hapus_episode" value="<?php echo htmlspecialchars($ep); ?>">
                                        <button type="submit" class="ml-2 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs shadow">Hapus</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="mb-8 mt-8">
                        <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-4 bg-indigo-50 p-6 rounded-xl shadow border border-indigo-200">
                            <label class="block text-gray-700 font-semibold" for="episode_file">Tambah Episode (video):</label>
                            <input type="file" name="episode_file" id="episode_file" accept="video/*" class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-white" required>
                            <button type="submit" name="tambah_episode" class="px-8 py-2 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow">Upload</button>
                        </form>
                    </div>
                    <form action="update.php?id=<?php echo $id; ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data anime ini? Semua episode dan cover akan dihapus!');" class="mb-8 flex flex-col items-center gap-4">
                        <input type="hidden" name="id" value="<?php echo (int)$anime['id_anime']; ?>">
                        <input type="hidden" name="delete" value="1">
                        <button type="submit" class="w-full py-3 rounded-full bg-red-500 text-white font-bold text-lg shadow-lg hover:bg-red-600 transition-all">Hapus Data Anime</button>
                    </form>
                <?php else: ?>
                    <div class="text-red-600 text-center text-lg py-12">Data anime tidak ditemukan.</div>
                <?php endif; ?>
            <?php elseif ($tipe === 'manga'): ?>
                <?php if ($manga): ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8 mt-6">
                        <div class="md:col-span-1 flex flex-col items-center justify-start">
                            <div class="w-48 h-64 rounded-2xl shadow-xl border-4 border-pink-200 overflow-hidden mb-4 flex items-center justify-center bg-white">
                                <?php if (!empty($manga['cover'])): ?>
                                    <img src="../image/<?php echo htmlspecialchars($manga['cover']); ?>" class="w-full h-full object-cover" alt="Cover Manga" />
                                <?php else: ?>
                                    <span class="text-gray-400 italic">No cover</span>
                                <?php endif; ?>
                            </div>
                            <form action="update.php?tipe=manga&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="w-full max-w-xs flex flex-col items-center gap-3 bg-white/80 p-4 rounded-xl shadow">
                                <input type="hidden" name="id" value="<?php echo (int)$manga['id_manga']; ?>">
                                <label class="block text-gray-700 font-semibold mb-2" for="cover_manga">Ganti Cover</label>
                                <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="file" id="cover_manga" name="cover_manga" accept="image/*">
                                <button type="submit" name="update_cover_manga" class="w-full py-2 rounded bg-pink-500 text-white font-semibold hover:bg-pink-700 transition-all shadow">Update Cover</button>
                            </form>
                        </div>
                        <div class="md:col-span-2">
                            <form action="update.php?tipe=manga&id=<?php echo $id; ?>" method="POST" class="space-y-8">
                                <input type="hidden" name="id" value="<?php echo (int)$manga['id_manga']; ?>">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="judul_manga">Judul Manga</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="text" id="judul_manga" name="judul_manga" value="<?php echo htmlspecialchars($manga['judul_manga']); ?>" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="genre_manga">Genre</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="text" id="genre_manga" name="genre_manga" value="<?php echo htmlspecialchars($manga['genre']); ?>" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="rating_manga">Rating</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="number" step="0.1" min="0" max="10" id="rating_manga" name="rating_manga" value="<?php echo htmlspecialchars($manga['rating']); ?>" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="synopsis_manga">Synopsis</label>
                                    <textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" id="synopsis_manga" name="synopsis_manga" rows="4" required><?php echo htmlspecialchars($manga['synopsis']); ?></textarea>
                                </div>
                                <button type="submit" name="update_data" class="w-full py-3 rounded-full bg-pink-600 text-white font-bold text-lg shadow hover:bg-pink-700 transition-all">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                    <?php if (!empty($chapters)) : ?>
                    <div class="mb-4 mt-8">
                        <h3 class="font-bold text-pink-700 mb-4 text-xl flex items-center gap-2">
                            <svg class="w-6 h-6 text-pink-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zm2 2v6h2V7H6zm4 0v6h2V7h-2z"/></svg>
                            Daftar Chapter
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($chapters as $ch): ?>
                                <li class="flex items-center justify-between bg-pink-50 rounded-lg px-4 py-2 shadow-sm border border-pink-200">
                                    <span class="font-mono text-pink-800"><?php echo htmlspecialchars($ch); ?></span>
                                    <form action="update.php?tipe=manga&id=<?php echo $id; ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="hapus_chapter" value="<?php echo htmlspecialchars($ch); ?>">
                                        <button type="submit" class="ml-2 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs shadow">Hapus</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="mb-8 mt-8">
                        <form action="update.php?tipe=manga&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-4 bg-pink-50 p-6 rounded-xl shadow border border-pink-200">
                            <label class="block text-gray-700 font-semibold" for="chapter_file">Tambah Chapter (pdf/zip):</label>
                            <input type="file" name="chapter_file" id="chapter_file" accept=".pdf,.zip" class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-white" required>
                            <button type="submit" name="tambah_chapter" class="px-8 py-2 rounded-lg bg-pink-600 text-white font-bold hover:bg-pink-700 transition-all shadow">Upload</button>
                        </form>
                    </div>
                    <form action="update.php?tipe=manga&id=<?php echo $id; ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data manga ini? Semua chapter dan cover akan dihapus!');" class="mb-8 flex flex-col items-center gap-4">
                        <input type="hidden" name="id" value="<?php echo (int)$manga['id_manga']; ?>">
                        <input type="hidden" name="delete" value="1">
                        <button type="submit" class="w-full py-3 rounded-full bg-red-500 text-white font-bold text-lg shadow-lg hover:bg-red-600 transition-all">Hapus Data Manga</button>
                    </form>
                <?php else: ?>
                    <div class="text-red-600 text-center text-lg py-12">Data manga tidak ditemukan.</div>
                <?php endif; ?>
            <?php elseif ($tipe === 'novel'): ?>
                <?php if ($novel): ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8 mt-6">
                        <div class="md:col-span-1 flex flex-col items-center justify-start">
                            <div class="w-48 h-64 rounded-2xl shadow-xl border-4 border-green-200 overflow-hidden mb-4 flex items-center justify-center bg-white">
                                <?php if (!empty($novel['cover'])): ?>
                                    <img src="../image/<?php echo htmlspecialchars($novel['cover']); ?>" class="w-full h-full object-cover" alt="Cover Novel" />
                                <?php else: ?>
                                    <span class="text-gray-400 italic">No cover</span>
                                <?php endif; ?>
                            </div>
                            <form action="update.php?tipe=novel&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="w-full max-w-xs flex flex-col items-center gap-3 bg-white/80 p-4 rounded-xl shadow">
                                <input type="hidden" name="id" value="<?php echo (int)$novel['id_novel']; ?>">
                                <label class="block text-gray-700 font-semibold mb-2" for="cover_novel">Ganti Cover</label>
                                <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-green-50" type="file" id="cover_novel" name="cover_novel" accept="image/*">
                                <button type="submit" name="update_cover_novel" class="w-full py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition-all shadow">Update Cover</button>
                            </form>
                        </div>
                        <div class="md:col-span-2">
                            <form action="update.php?tipe=novel&id=<?php echo $id; ?>" method="POST" class="space-y-8">
                                <input type="hidden" name="id" value="<?php echo (int)$novel['id_novel']; ?>">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="judul_novel">Judul Novel</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-green-50" type="text" id="judul_novel" name="judul_novel" value="<?php echo htmlspecialchars($novel['judul_novel']); ?>" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="genre_novel">Genre</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-green-50" type="text" id="genre_novel" name="genre_novel" value="<?php echo htmlspecialchars($novel['genre']); ?>" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2" for="rating_novel">Rating</label>
                                        <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-green-50" type="number" step="0.1" min="0" max="10" id="rating_novel" name="rating_novel" value="<?php echo htmlspecialchars($novel['rating']); ?>" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="synopsis_novel">Synopsis</label>
                                    <textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-green-50" id="synopsis_novel" name="synopsis_novel" rows="4" required><?php echo htmlspecialchars($novel['synopsis']); ?></textarea>
                                </div>
                                <button type="submit" name="update_data" class="w-full py-3 rounded-full bg-green-600 text-white font-bold text-lg shadow hover:bg-green-700 transition-all">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                    <?php if (!empty($volumes)) : ?>
                    <div class="mb-4 mt-8">
                        <h3 class="font-bold text-green-700 mb-4 text-xl flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zm2 2v6h2V7H6zm4 0v6h2V7h-2z"/></svg>
                            Daftar Volume
                        </h3>
                        <ul class="space-y-2">
                            <?php foreach ($volumes as $v): ?>
                                <li class="flex items-center justify-between bg-green-50 rounded-lg px-4 py-2 shadow-sm border border-green-200">
                                    <span class="font-mono text-green-800"><?php echo htmlspecialchars($v); ?></span>
                                    <form action="update.php?tipe=novel&id=<?php echo $id; ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="hapus_volume" value="<?php echo htmlspecialchars($v); ?>">
                                        <button type="submit" class="ml-2 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs shadow">Hapus</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="mb-8 mt-8">
                        <form action="update.php?tipe=novel&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-4 bg-green-50 p-6 rounded-xl shadow border border-green-200">
                            <label class="block text-gray-700 font-semibold" for="volume_file">Tambah Volume (pdf/zip):</label>
                            <input type="file" name="volume_file" id="volume_file" accept=".pdf,.zip" class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-400 outline-none bg-white" required>
                            <button type="submit" name="tambah_volume" class="px-8 py-2 rounded-lg bg-green-600 text-white font-bold hover:bg-green-700 transition-all shadow">Upload</button>
                        </form>
                    </div>
                    <form action="update.php?tipe=novel&id=<?php echo $id; ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data novel ini? Semua volume dan cover akan dihapus!');" class="mb-8 flex flex-col items-center gap-4">
                        <input type="hidden" name="id" value="<?php echo (int)$novel['id_novel']; ?>">
                        <input type="hidden" name="delete" value="1">
                        <button type="submit" class="w-full py-3 rounded-full bg-red-500 text-white font-bold text-lg shadow-lg hover:bg-red-600 transition-all">Hapus Data Novel</button>
                    </form>
                <?php else: ?>
                    <div class="text-red-600 text-center text-lg py-12">Data novel tidak ditemukan.</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-red-600 text-center text-lg py-12">Tipe tidak dikenal.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
