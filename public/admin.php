
<?php
session_start();
if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
}
include '../action/koneksi.php';

// Cek role admin
$username = $_SESSION['user'];
$query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);
if (!isset($user['level']) || $user['level'] !== 'admin') {
        header('Location: dashboard.php');
        exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | NimeTV</title>
        <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-tr from-indigo-50 via-white to-purple-100 min-h-screen flex">
    <!-- Sidebar -->
    <?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>
    <!-- Main Dashboard -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="w-full bg-white shadow flex items-center justify-between px-10 py-6 border-b border-indigo-100">
            <div>
                <h1 class="text-3xl font-extrabold text-indigo-700">Dashboard Admin</h1>
                <p class="text-gray-500">Selamat datang, <span class="font-bold text-indigo-600"><?php echo htmlspecialchars($user['nama_user'] ?? $user['username']); ?></span></p>
            </div>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.657 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Admin
                </span>
            </div>
        </header>

        <main class="flex-1 px-10 py-8 bg-gradient-to-tr from-indigo-50 via-white to-purple-50">
            <!-- Notif -->
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'update-success'): ?>
                <div class="w-full max-w-2xl mx-auto mb-6">
                    <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-xl text-center text-lg font-semibold shadow animate-fade-in-up">
                        Data berhasil diupdate!
                    </div>
                </div>
            <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="w-full max-w-2xl mx-auto mb-6">
                    <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-xl text-center text-lg font-semibold shadow animate-fade-in-up">
                        Anime berhasil dihapus!
                    </div>
                </div>
            <?php endif; ?>

            <!-- Statistik Card -->
            <section class="grid grid-cols-1 md:grid-cols-5 gap-8 mb-10">
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center border border-indigo-100">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-tr from-indigo-400 to-purple-400 shadow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h4"/></svg>
                    </span>
                    <div class="mt-3 text-lg font-bold text-indigo-700">Total Anime</div>
                    <div class="text-2xl font-extrabold text-indigo-900">
                        <?php $animeCount = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM anime"); $animeTotal = mysqli_fetch_assoc($animeCount); echo $animeTotal['total'] ?? 0; ?>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center border border-indigo-100">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 shadow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20l9-5-9-5-9 5 9 5z"/></svg>
                    </span>
                    <div class="mt-3 text-lg font-bold text-yellow-700">Total Episode</div>
                    <div class="text-2xl font-extrabold text-yellow-900">
                        <?php
                            $totalEpisode = 0;
                            $animeQ = mysqli_query($koneksi, "SELECT judul_anime FROM anime");
                            while ($anime = mysqli_fetch_assoc($animeQ)) {
                                $folder = '../video/' . $anime['judul_anime'];
                                if (is_dir($folder)) {
                                    $files = scandir($folder);
                                    foreach ($files as $file) {
                                        if (preg_match('/\.(mp4|mkv|avi|mov|flv|webm)$/i', $file)) {
                                            $totalEpisode++;
                                        }
                                    }
                                }
                            }
                            echo $totalEpisode;
                        ?>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center border border-indigo-100">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-tr from-pink-400 to-purple-400 shadow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.657 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <div class="mt-3 text-lg font-bold text-pink-700">Total User</div>
                    <div class="text-2xl font-extrabold text-pink-900">
                        <?php $userCount = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM user"); $userTotal = mysqli_fetch_assoc($userCount); echo $userTotal['total'] ?? 0; ?>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center border border-indigo-100">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-tr from-pink-500 to-pink-700 shadow">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"/></svg>
                    </span>
                    <div class="mt-3 text-lg font-bold text-pink-700">Total Manga</div>
                    <div class="text-2xl font-extrabold text-pink-900">
                        <?php $mangaCount = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM manga"); $mangaTotal = mysqli_fetch_assoc($mangaCount); echo $mangaTotal['total'] ?? 0; ?>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center border border-indigo-100">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-tr from-green-400 to-green-600 shadow">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"/></svg>
                    </span>
                    <div class="mt-3 text-lg font-bold text-green-700">Total Novel</div>
                    <div class="text-2xl font-extrabold text-green-900">
                        <?php $novelCount = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM novel"); $novelTotal = mysqli_fetch_assoc($novelCount); echo $novelTotal['total'] ?? 0; ?>
                    </div>
                </div>
            </section>

            <!-- List Anime -->
            <section class="w-full max-w-6xl mx-auto mt-2">
                <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button id="slide-left" class="p-2 rounded-full bg-gray-200 hover:bg-indigo-200 transition-all shadow" onclick="changeType(-1)">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <h2 id="type-title" class="text-2xl font-bold text-indigo-700">Daftar Anime di Database</h2>
                        <button id="slide-right" class="p-2 rounded-full bg-gray-200 hover:bg-indigo-200 transition-all shadow" onclick="changeType(1)">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <form method="GET" class="flex items-center gap-2 w-full md:w-auto">
                        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Cari judul..." class="px-3 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-400 outline-none w-full md:w-64" />
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all">Cari</button>
                    </form>
                </div>
                <script>
                // JS untuk slide Anime/Manga/Novel
                let types = [
                  {key: 'anime', label: 'Daftar Anime di Database'},
                  {key: 'manga', label: 'Daftar Manga di Database'},
                  {key: 'novel', label: 'Daftar Novel di Database'}
                ];
                let currentType = 0;
                function changeType(dir) {
                  currentType = (currentType + dir + types.length) % types.length;
                  document.getElementById('type-title').textContent = types[currentType].label;
                  // Ganti query string tanpa reload
                  const url = new URL(window.location);
                  url.searchParams.set('tipe', types[currentType].key);
                  window.location = url;
                }
                // On load, set title sesuai tipe di query
                window.addEventListener('DOMContentLoaded', () => {
                  const url = new URL(window.location);
                  const tipe = url.searchParams.get('tipe') || 'anime';
                  currentType = types.findIndex(t => t.key === tipe);
                  if (currentType === -1) currentType = 0;
                  document.getElementById('type-title').textContent = types[currentType].label;
                });
                </script>
                <div class="overflow-hidden rounded-lg p-2">
                    <?php
                        $tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'anime';
                        $where = '';
                        $table = 'anime';
                        $judulField = 'judul_anime';
                        $imageField = 'image';
                        $ratingField = 'rating';
                        $idField = 'id_anime';
                        if ($tipe === 'manga') {
                            $table = 'manga';
                            $judulField = 'judul_manga';
                            $imageField = 'cover';
                            $ratingField = 'rating';
                            $idField = 'id_manga';
                        } else if ($tipe === 'novel') {
                            $table = 'novel';
                            $judulField = 'judul_novel';
                            $imageField = 'cover';
                            $ratingField = 'rating';
                            $idField = 'id_novel';
                        }
                        if (isset($_GET['search']) && $_GET['search'] !== '') {
                            $search = mysqli_real_escape_string($koneksi, $_GET['search']);
                            $where = "WHERE $judulField LIKE '%$search%'";
                        }
                        $query = "SELECT * FROM $table $where ORDER BY $idField DESC";
                        $dataQ = mysqli_query($koneksi, $query);
                        if (!$dataQ) {
                            echo '<div class="text-red-600 p-4">Query error: ' . mysqli_error($koneksi) . '</div>';
                        } else {
                    ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while ($row = mysqli_fetch_assoc($dataQ)): ?>
                            <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
                                <div class="mx-auto rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center mb-4 w-28 sm:w-32 md:w-36 lg:w-40" style="aspect-ratio:9/10;">
                                    <?php if (!empty($row[$imageField])): ?>
                                        <img src="../image/<?php echo htmlspecialchars($row[$imageField]); ?>" class="w-full h-full object-cover" alt="cover">
                                    <?php else: ?>
                                        <div class="text-sm text-gray-400 italic">No image</div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">
                                        <?php if ($tipe === 'anime'): ?>
                                            <a href="update.php?id=<?php echo (int)$row['id_anime']; ?>" class="hover:underline hover:text-indigo-600 transition-all"><?php echo htmlspecialchars($row['judul_anime']); ?></a>
                                        <?php elseif ($tipe === 'manga'): ?>
                                            <a href="update.php?tipe=manga&id=<?php echo (int)$row['id_manga']; ?>" class="hover:underline hover:text-pink-600 transition-all"><?php echo htmlspecialchars($row['judul_manga']); ?></a>
                                        <?php elseif ($tipe === 'novel'): ?>
                                            <a href="update.php?tipe=novel&id=<?php echo (int)$row['id_novel']; ?>" class="hover:underline hover:text-green-600 transition-all"><?php echo htmlspecialchars($row['judul_novel']); ?></a>
                                        <?php else: ?>
                                            <span><?php echo htmlspecialchars($row[$judulField]); ?></span>
                                        <?php endif; ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-3 truncate"><?php echo htmlspecialchars(substr($row['synopsis'] ?? $row['synopsis_manga'] ?? $row['synopsis_novel'] ?? '', 0, 140)); ?><?php echo (strlen($row['synopsis'] ?? $row['synopsis_manga'] ?? $row['synopsis_novel'] ?? '') > 140) ? '...' : ''; ?></p>
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    <div class="inline-flex items-center gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                                            <span><?php echo htmlspecialchars($row[$ratingField] ?? '-'); ?></span>
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <?php
                                            if ($tipe === 'anime') {
                                                $folder = '../video/' . $row[$judulField];
                                                $episode_count = 0;
                                                if (is_dir($folder)) {
                                                    $files = scandir($folder);
                                                    foreach ($files as $file) {
                                                        if (preg_match('/\.(mp4|mkv|avi|mov|flv|webm)$/i', $file)) {
                                                            $episode_count++;
                                                        }
                                                    }
                                                }
                                                echo $episode_count . ' Episode';
                                            } elseif ($tipe === 'manga') {
                                                $safeTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($row['judul_manga']));
                                                $perFolder = '../manga/' . ($safeTitle ?: 'untitled') . '/';
                                                $volumeCount = 0;
                                                if (is_dir($perFolder)) {
                                                    $files = scandir($perFolder);
                                                    foreach ($files as $file) {
                                                        if (preg_match('/\.(pdf|zip)$/i', $file)) {
                                                            $volumeCount++;
                                                        }
                                                    }
                                                } else {
                                                    $volumeDir = '../manga/';
                                                    if (is_dir($volumeDir)) {
                                                        $files = scandir($volumeDir);
                                                        foreach ($files as $file) {
                                                            if (preg_match('/\.(pdf|zip)$/i', $file)) {
                                                                if (strpos($file, (string)$row['id_manga']) !== false || stripos($file, str_replace(' ', '', $row['judul_manga'])) !== false) {
                                                                    $volumeCount++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                echo $volumeCount . ' Chapter';
                                            } elseif ($tipe === 'novel') {
                                                $safeTitleN = preg_replace('/[^a-zA-Z0-9_-]/', '_', trim($row['judul_novel'] ?? ''));
                                                $novelFolder = '../novel/' . ($safeTitleN ?: 'untitled') . '/';
                                                $volumeCount = 0;
                                                if (is_dir($novelFolder)) {
                                                    $filesN = scandir($novelFolder);
                                                    foreach ($filesN as $f) {
                                                        if (preg_match('/\.(pdf|zip)$/i', $f)) {
                                                            $volumeCount++;
                                                        }
                                                    }
                                                } else {
                                                    $volumeDirN = '../novel/';
                                                    if (is_dir($volumeDirN)) {
                                                        $filesN = scandir($volumeDirN);
                                                        foreach ($filesN as $f) {
                                                            if (preg_match('/\.(pdf|zip)$/i', $f)) {
                                                                if (strpos($f, (string)($row['id_novel'] ?? '')) !== false || stripos($f, str_replace(' ', '', ($row['judul_novel'] ?? ''))) !== false) {
                                                                    $volumeCount++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                echo $volumeCount > 0 ? ($volumeCount . ' Volume') : '-';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center gap-3">
                                    <a href="<?php echo ($tipe === 'anime') ? 'update.php?id=' . (int)$row['id_anime'] : 'update.php?tipe=' . $tipe . '&id=' . (int)$row[$idField]; ?>" class="flex-1 text-center py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">Edit</a>
                                    <a href="" onclick="alert('Gunakan halaman edit untuk menghapus'); return false;" class="py-2 px-3 rounded-lg bg-red-100 text-red-700 text-sm">Delete</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php } ?>
                </div>
            </section>
        </main>
    </div>
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.8s cubic-bezier(.4,0,.2,1) both;
        }
    </style>
</body>
</html>

