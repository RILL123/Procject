
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
            <section class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
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
                <div class="overflow-x-auto rounded-lg shadow bg-gradient-to-br from-indigo-50 to-white p-4">
                    <table class="min-w-full bg-white rounded-xl overflow-hidden">
                        <thead class="bg-indigo-700">
                            <tr>
                                <th class="py-3 px-6 text-center text-xs font-bold text-white uppercase tracking-wider">Image</th>
                                <th class="py-3 px-6 text-center text-xs font-bold text-white uppercase tracking-wider">Judul Anime</th>
                                <th class="py-3 px-6 text-center text-xs font-bold text-white uppercase tracking-wider">Rating</th>
                                <th class="py-3 px-6 text-center text-xs font-bold text-white uppercase tracking-wider">Jumlah Episode</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-100">
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
                                echo '<tr><td colspan="2" class="text-red-600 py-4 px-6">Query error: ' . mysqli_error($koneksi) . '</td></tr>';
                            } else {
                                while ($row = mysqli_fetch_assoc($dataQ)):
                        ?>
                            <tr class="hover:bg-indigo-50 transition-all">
                                <td class="py-4 px-6 text-center">
                                    <?php if (!empty($row[$imageField])): ?>
                                        <div class="w-[80px] h-[120px] rounded border border-indigo-200 shadow-sm overflow-hidden bg-white mx-auto flex items-center justify-center">
                                            <img src="../image/<?php echo htmlspecialchars($row[$imageField]); ?>" class="w-full h-full object-cover transition-transform duration-200 hover:scale-105" />
                                        </div>
                                    <?php else: ?>
                                        <div class="w-[80px] h-[120px] rounded border-2 border-dashed border-gray-300 bg-gray-100 flex items-center justify-center text-gray-400 italic mx-auto text-xs">
                                            No image
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-center text-gray-800 font-semibold align-middle text-lg">
                                    <?php if ($tipe === 'anime'): ?>
                                        <a href="update.php?id=<?php echo (int)$row['id_anime']; ?>" class="hover:underline hover:text-indigo-600 transition-all"><?php echo htmlspecialchars($row['judul_anime']); ?></a>
                                    <?php elseif ($tipe === 'manga'): ?>
                                        <a href="update_manga.php?tipe=manga&id=<?php echo (int)$row['id_manga']; ?>" class="hover:underline hover:text-pink-600 transition-all"><?php echo htmlspecialchars($row['judul_manga']); ?></a>
                                    <?php else: ?>
                                        <span><?php echo htmlspecialchars($row[$judulField]); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-center align-middle">
                                    <span class="inline-flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.38-2.454a1 1 0 00-1.175 0l-3.38 2.454c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/></svg>
                                        <span class="text-gray-700 font-medium text-lg"><?php echo htmlspecialchars($row[$ratingField] ?? '-'); ?></span>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center align-middle">
                                    <?php if ($tipe === 'anime'): ?>
                                        <?php
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
                                        ?>
                                    <?php elseif ($tipe === 'manga'): ?>
                                        <?php
                                            $volumeDir = '../manga/';
                                            $volumeCount = 0;
                                            if (is_dir($volumeDir)) {
                                                $files = scandir($volumeDir);
                                                foreach ($files as $file) {
                                                    if (preg_match('/\\.(pdf|zip)$/i', $file)) {
                                                        if (strpos($file, (string)$row['id_manga']) !== false || stripos($file, str_replace(' ', '', $row['judul_manga'])) !== false) {
                                                            $volumeCount++;
                                                        }
                                                    }
                                                }
                                            }
                                            echo $volumeCount . ' Chapter';
                                        ?>
                                    <?php elseif ($tipe === 'novel'): ?>
                                        <?php echo isset($row['file']) ? 'File: ' . htmlspecialchars($row['file']) : '-'; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; }
                        ?>
                        </tbody>
                    </table>
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

