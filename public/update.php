
<?php
session_start();
include '../action/koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'anime';
$msg = '';
$anime = null;
$episodes = [];
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

// Handler update data anime
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_data']) && $tipe === 'anime') {
    updateAnime($koneksi, $id, $msg, $anime);
}

// Ambil data sesuai tipe
if ($id > 0 && $tipe === 'anime') {
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
// Proses hapus anime
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['id'])) {
    $id_delete = intval($_POST['id']);
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
}
        // Proses hapus volume manga
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_volume'])) {
            $id_manga = intval($_POST['id_manga']);
            $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id_manga LIMIT 1");
            $mangaData = mysqli_fetch_assoc($mangaQ);
            if ($mangaData && !empty($mangaData['volume'])) {
                $volumePath = '../manga/' . $mangaData['volume'];
                if (is_file($volumePath)) {
                    unlink($volumePath);
                }
                $sql = "UPDATE manga SET volume='' WHERE id_manga=$id_manga";
                mysqli_query($koneksi, $sql);
                $msg = '<div class="mb-4 text-green-700 font-semibold bg-green-100 border border-green-300 rounded-lg px-4 py-2">Volume manga berhasil dihapus.</div>';
                // Refresh data
                $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id LIMIT 1");
                $manga = mysqli_fetch_assoc($mangaQ);
            } else {
                $msg = '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">Volume tidak ditemukan.</div>';
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anime | NimeTV</title>
                            <?php if (!empty($manga['volume'])): ?>
                                <button type="submit" name="hapus_volume" value="1" onclick="return confirm('Yakin ingin menghapus volume ini?')" class="px-8 py-2 rounded-lg bg-red-500 text-white font-bold hover:bg-red-700 transition-all shadow">Hapus Volume</button>
                                <span class="text-sm text-gray-600 ml-2">Volume saat ini: <b><?php echo htmlspecialchars($manga['volume']); ?></b></span>
                            <?php endif; ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-50 via-white to-purple-100 min-h-screen flex">
    <?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>
    <div class="flex-1 flex flex-col min-h-screen w-full items-center justify-center">
        <div class="w-full max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8 mt-10 border border-indigo-200">
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-8">Edit Data Anime</h1>
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
            <!-- List episode -->
            <?php if ($tipe === 'anime' && $anime): ?>
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
                <div class="text-red-600 text-center text-lg py-12">Data tidak ditemukan.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
