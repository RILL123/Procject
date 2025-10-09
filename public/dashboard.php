<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: public/login.php');
    exit();
}
include '../action/koneksi.php';

// Ambil data user dari session
$username = $_SESSION['user'];
$query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";

$result = mysqli_query($koneksi, $query);
if (!$result) {
  echo '<div style="color:red;text-align:center;margin-top:2em;">Gagal mengambil data user: ' . htmlspecialchars(mysqli_error($koneksi)) . '</div>';
  exit();
}
$user = mysqli_fetch_assoc($result);

// Cek role user
$role = isset($user['role']) ? $user['role'] : 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/dashboard.js"></script>
</head>
  <body class="bg-gradient-to-tr from-indigo-100 via-white to-purple-100 min-h-screen flex flex-col">
    <?php include_once __DIR__ . '/../views/partials/navbar_user.php'; ?>
    <div class="h-16"></div>
    <main class="flex-1 flex flex-col items-center justify-center py-10">
      <section class="w-full max-w-2xl bg-white/90 rounded-3xl shadow-2xl p-10 mt-8 animate-fade-in-up text-center border border-indigo-100">
        <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-700 mb-4 drop-shadow-lg flex flex-col items-center gap-2">
          <span>Selamat Datang,</span>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500"><?php echo htmlspecialchars($user['nama_user'] ?? $user['username']); ?></span>
        </h1>
      </section>
      <!-- List Anime -->
      <section class="w-full max-w-6xl mx-auto mt-12">
        <h2 class="text-3xl font-extrabold text-indigo-700 mb-8 text-center drop-shadow">Daftar Anime Tersedia</h2>
        <!-- Search Engine -->
        <div class="flex justify-center mb-8">
          <input id="animeSearch" type="text" placeholder="Cari anime, genre, atau rating..." class="w-full max-w-md px-5 py-3 rounded-full border-2 border-indigo-200 focus:ring-2 focus:ring-indigo-400 outline-none text-lg shadow transition-all" />
        </div>
        <div id="animeGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php
        $animeQ = mysqli_query($koneksi, "SELECT * FROM anime ORDER BY id_anime DESC");
        if ($animeQ):
          while ($anime = mysqli_fetch_assoc($animeQ)):
        ?>
          <div class="anime-card bg-white/95 rounded-3xl shadow-xl overflow-hidden flex flex-col items-center hover:scale-[1.02] hover:shadow-xl border border-indigo-200 transition-all duration-300 group focus:ring-4 focus:ring-indigo-200 outline-none">
            <div class="w-full h-40 bg-gradient-to-tr from-indigo-100 via-white to-purple-100 flex items-center justify-center overflow-hidden relative">
              <img src="../image/<?php echo htmlspecialchars($anime['image']); ?>" alt="<?php echo htmlspecialchars($anime['judul_anime']); ?>" class="w-full h-full object-cover object-center transition-all duration-300 group-hover:scale-105">
              <span class="absolute top-2 right-2 bg-white/80 px-2 py-0.5 rounded-full text-xs font-bold text-purple-600 shadow">Rating: <?php echo htmlspecialchars($anime['rating']); ?></span>
            </div>
            <div class="p-4 w-full flex-1 flex flex-col justify-between">
              <h3 class="text-lg font-extrabold text-indigo-700 mb-1 text-center truncate group-hover:text-purple-600 transition-all"><?php echo htmlspecialchars($anime['judul_anime']); ?></h3>
              <div class="flex flex-wrap justify-center gap-2 mb-1">
                <span class="inline-block px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-600 text-xs font-semibold">Genre: <?php echo htmlspecialchars($anime['genre']); ?></span>
              </div>
              <div class="text-gray-500 text-sm text-center truncate mb-3"><?php echo htmlspecialchars($anime['synopsis']); ?></div>
              <div class="mt-2 flex items-center justify-center">
                <a href="streaming.php?id=<?php echo $anime['id_anime']; ?>" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">Menonton</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
        <?php else: ?>
          <div class="col-span-full text-center text-red-500">Gagal mengambil data anime: <?php echo htmlspecialchars(mysqli_error($koneksi)); ?></div>
        <?php endif; ?>
        </div>
        <script>
          
// Simple client-side search (Tailwind friendly)
document.getElementById('animeSearch').addEventListener('input', function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll('#animeGrid .anime-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(val)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
});
        </script>
      </section>
    </main>
      <!-- List Manga -->
      <section class="w-full max-w-6xl mx-auto mt-16">
        <h2 class="text-3xl font-extrabold text-purple-700 mb-8 text-center drop-shadow">Daftar Manga Tersedia</h2>
        <!-- Search Engine Manga -->
        <div class="flex justify-center mb-8">
          <input id="mangaSearch" type="text" placeholder="Cari manga, genre, atau author..." class="w-full max-w-md px-5 py-3 rounded-full border-2 border-purple-200 focus:ring-2 focus:ring-purple-400 outline-none text-lg shadow transition-all" />
        </div>
        <div id="mangaGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php
        $mangaQ = mysqli_query($koneksi, "SELECT * FROM manga ORDER BY id_manga DESC");
        if ($mangaQ):
          while ($manga = mysqli_fetch_assoc($mangaQ)):
        ?>
          <div class="manga-card bg-white/95 rounded-3xl shadow-xl overflow-hidden flex flex-col items-center hover:scale-[1.02] hover:shadow-xl border border-purple-200 transition-all duration-300 group focus:ring-4 focus:ring-purple-200 outline-none">
            <div class="w-full h-40 bg-gradient-to-tr from-purple-100 via-white to-indigo-100 flex items-center justify-center overflow-hidden relative">
              <img src="../image/<?php echo htmlspecialchars($manga['cover']); ?>" alt="<?php echo htmlspecialchars($manga['judul_manga']); ?>" class="w-full h-full object-cover object-center transition-all duration-300 group-hover:scale-105">
              <span class="absolute top-2 right-2 bg-white/80 px-2 py-0.5 rounded-full text-xs font-bold text-purple-600 shadow">Rating: <?php echo htmlspecialchars($manga['rating']); ?></span>
            </div>
            <div class="p-4 w-full flex-1 flex flex-col justify-between">
              <h3 class="text-lg font-extrabold text-purple-700 mb-1 text-center truncate group-hover:text-indigo-600 transition-all"><?php echo htmlspecialchars($manga['judul_manga']); ?></h3>
              <div class="flex flex-wrap justify-center gap-2 mb-1">
                <span class="inline-block px-2 py-0.5 rounded-full bg-purple-100 text-purple-600 text-xs font-semibold">Genre: <?php echo htmlspecialchars($manga['genre']); ?></span>
              </div>
              <div class="text-gray-500 text-sm text-center truncate mb-3"><?php echo htmlspecialchars($manga['synopsis']); ?></div>
              <div class="mt-2 flex items-center justify-center">
                <a href="baca_manga.php?id=<?php echo $manga['id_manga']; ?>" class="px-4 py-2 rounded-lg bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">Baca</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
        <?php else: ?>
          <div class="col-span-full text-center text-red-500">Gagal mengambil data manga: <?php echo htmlspecialchars(mysqli_error($koneksi)); ?></div>
        <?php endif; ?>
        </div>
        <script>
// Simple client-side search for manga
document.getElementById('mangaSearch').addEventListener('input', function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll('#mangaGrid .manga-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(val)) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
});
        </script>
      </section>
    <footer class="bg-white text-gray-600 py-8 mt-12 border-t">
      <div class="max-w-7xl mx-auto px-4 text-center">
        &copy; 2025 NimeTV. All rights reserved.
      </div>
    </footer>
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
