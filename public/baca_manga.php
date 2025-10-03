<?php
// Halaman baca manga berdasarkan id manga
session_start();
include '../action/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$manga = null;
$volumes = [];

// Ambil data manga
if ($id > 0) {
    $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga WHERE id_manga = $id LIMIT 1");
    $manga = mysqli_fetch_assoc($mangaQ);
    if ($manga && !empty($manga['volume'])) {
        // volume bisa berupa nama file PDF/ZIP, bisa juga array jika multi volume
        $volArr = explode(',', $manga['volume']);
        foreach ($volArr as $vol) {
            $vol = trim($vol);
            if ($vol) $volumes[] = $vol;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Manga | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-pink-100 via-white to-purple-100 min-h-screen flex flex-col">
    <?php include_once __DIR__ . '/../views/partials/navbar_user.php'; ?>
    <div class="h-16"></div>
    <main class="flex-1 flex flex-col items-center justify-center py-10">
        <div class="w-full max-w-4xl mx-auto relative">
            <?php if ($manga): ?>
            <div class="relative z-10 bg-white/90 rounded-3xl shadow-2xl p-8 border border-pink-100 backdrop-blur-xl">
                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Info manga -->
                    <div class="md:w-1/3 w-full flex flex-col gap-4 items-center md:items-start">
                        <div class="w-56 h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-pink-200 mb-2 flex items-center justify-center bg-white group">
                            <img src="../image/<?php echo htmlspecialchars($manga['cover']); ?>" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
                        </div>
                        <h2 class="text-3xl font-extrabold text-pink-700 mb-1 drop-shadow-lg"><?php echo htmlspecialchars($manga['judul_manga']); ?></h2>
                        <div class="flex flex-wrap gap-2 mb-2">
                            <span class="inline-block px-4 py-1 rounded-full bg-pink-100 text-pink-600 text-sm font-semibold shadow">Genre: <?php echo htmlspecialchars($manga['genre']); ?></span>
                            <span class="inline-block px-4 py-1 rounded-full bg-purple-100 text-purple-600 text-sm font-semibold shadow">Rating: <?php echo htmlspecialchars($manga['rating']); ?></span>
                        </div>
                        <div class="text-gray-700 text-base mb-2 text-justify max-w-xs"><b>Synopsis:</b><br><?php echo nl2br(htmlspecialchars($manga['synopsis'])); ?></div>
                    </div>
                    <!-- Manga reader / daftar volume -->
                    <div class="md:w-2/3 w-full flex flex-col gap-8">
                        <div class="w-full flex flex-col gap-4">
                            <h3 class="font-bold text-pink-700 mb-2 text-lg tracking-wide">Baca Volume</h3>
                            <?php if (!empty($volumes)): ?>
                                <ul class="space-y-3">
                                <?php foreach ($volumes as $i => $vol): ?>
                                    <li>
                                        <a href="../manga/<?php echo rawurlencode($vol); ?>" target="_blank" class="px-5 py-3 rounded-xl border font-mono text-base font-semibold shadow-md transition-all duration-200 bg-pink-50 text-pink-700 border-pink-200 hover:bg-pink-100 hover:scale-105 block text-center">
                                            Volume <?php echo ($i+1); ?> - Baca PDF/ZIP
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="text-gray-400">Belum ada volume tersedia.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="text-red-600 text-center text-lg py-12">Data manga tidak ditemukan.</div>
            <?php endif; ?>
        </div>
    </main>
    <footer class="bg-white text-gray-600 py-8 mt-12 border-t">
      <div class="max-w-7xl mx-auto px-4 text-center">
        &copy; 2025 NimeTV. All rights reserved.
      </div>
    </footer>
</body>
</html>
