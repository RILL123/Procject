<?php
session_start();
include '../action/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$anime = null;
$episodes = [];
$selected_ep = '';
$msg = '';

// Ambil data anime
if ($id > 0) {
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
			sort($episodes);
		}
	}
}

// Pilih episode
if (isset($_GET['ep']) && in_array($_GET['ep'], $episodes)) {
	$selected_ep = $_GET['ep'];
} elseif (!empty($episodes)) {
	$selected_ep = $episodes[0];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Streaming | NimeTV</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-100 via-white to-purple-100 min-h-screen flex flex-col">
	<?php include_once __DIR__ . '/../views/partials/navbar_user.php'; ?>
	<div class="h-16"></div>
	<main class="flex-1 flex flex-col items-center justify-center py-10">
		<div class="w-full max-w-6xl mx-auto relative">
			<?php if ($anime): ?>
			<!-- Background blur cover -->
			<div class="absolute inset-0 z-0 rounded-3xl overflow-hidden">
				<img src="../image/<?php echo htmlspecialchars($anime['image']); ?>" alt="bg" class="w-full h-full object-cover object-center scale-110 blur-2xl opacity-40">
				<div class="absolute inset-0 bg-gradient-to-tr from-white/80 via-indigo-100/60 to-purple-100/60"></div>
			</div>
			<div class="relative z-10 bg-white/90 rounded-3xl shadow-2xl p-8 border border-indigo-100 backdrop-blur-xl">
				<div class="flex flex-col md:flex-row gap-10">
					<!-- Info anime -->
					<div class="md:w-1/3 w-full flex flex-col gap-4 items-center md:items-start">
						<div class="w-56 h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-indigo-200 mb-2 flex items-center justify-center bg-white group">
							<img src="../image/<?php echo htmlspecialchars($anime['image']); ?>" alt="Cover" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-300">
						</div>
						<h2 class="text-3xl font-extrabold text-indigo-700 mb-1 drop-shadow-lg"><?php echo htmlspecialchars($anime['judul_anime']); ?></h2>
						<div class="flex flex-wrap gap-2 mb-2">
							<span class="inline-block px-4 py-1 rounded-full bg-indigo-100 text-indigo-600 text-sm font-semibold shadow">Genre: <?php echo htmlspecialchars($anime['genre']); ?></span>
							<span class="inline-block px-4 py-1 rounded-full bg-purple-100 text-purple-600 text-sm font-semibold shadow">Rating: <?php echo htmlspecialchars($anime['rating']); ?></span>
						</div>
						<div class="text-gray-700 text-base mb-2 text-justify max-w-xs"><b>Synopsis:</b><br><?php echo nl2br(htmlspecialchars($anime['synopsis'])); ?></div>
					</div>
					<!-- Video player & episode list -->
					<div class="md:w-2/3 w-full flex flex-col gap-8">
						<div class="w-full aspect-video bg-black rounded-2xl shadow-2xl overflow-hidden flex items-center justify-center border-4 border-indigo-200">
							<?php if ($selected_ep): ?>
							<video id="videoPlayer" src="<?php echo $folder . '/' . rawurlencode($selected_ep); ?>" controls class="w-full h-full rounded-2xl bg-black" poster="../image/<?php echo htmlspecialchars($anime['image']); ?>" style="max-height:480px;">
								Sorry, your browser doesn't support embedded videos.
							</video>
							<?php else: ?>
							<span class="text-gray-400">Tidak ada episode tersedia.</span>
							<?php endif; ?>
						</div>
						<div class="flex flex-col gap-2 mt-2">
							<h3 class="font-bold text-indigo-700 mb-2 text-lg tracking-wide">Daftar Episode</h3>
							<div class="flex flex-wrap gap-3">
							<?php foreach ($episodes as $i => $ep): ?>
								<a href="?id=<?php echo $id; ?>&ep=<?php echo urlencode($ep); ?>"
								   class="px-5 py-2 rounded-xl border font-mono text-base font-semibold shadow-md transition-all duration-200 focus:ring-2 focus:ring-indigo-300 outline-none
								   <?php echo ($ep === $selected_ep)
									   ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-indigo-700 scale-105 ring-2 ring-indigo-300'
									   : 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100 hover:scale-105'; ?>"
								   title="Tonton episode <?php echo ($i+1); ?>">
									Episode <?php echo ($i+1); ?>
								</a>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php else: ?>
				<div class="text-red-600 text-center text-lg py-12">Data anime tidak ditemukan.</div>
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
