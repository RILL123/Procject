<?php
$msg = '';
$isManga = (isset($_GET['type']) && $_GET['type'] === 'manga');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	ob_start();
	if ($isManga) {
		if (file_exists('../action/aksi_upload_manga.php')) {
			include '../action/aksi_upload_manga.php';
		} else {
			echo '<div class="mb-4 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg px-4 py-2">aksi_upload_manga.php belum dibuat.</div>';
		}
	} else {
		include '../action/aksi_upload.php';
	}
	$msg = ob_get_clean();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $isManga ? 'Upload Manga' : 'Upload Anime'; ?> | NimeTV</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-50 via-white to-purple-100 min-h-screen flex">
	<?php include_once __DIR__ . '/../views/partials/navbar_admin.php'; ?>
	<div class="flex-1 flex flex-col min-h-screen w-full items-center justify-center">
		<div class="w-full max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8 mt-10 border border-indigo-200">
			<h1 class="text-3xl font-extrabold text-indigo-700 mb-8">
				<?php echo $isManga ? 'Tambah Data Manga' : 'Tambah Data Anime'; ?>
			</h1>
			<?php echo $msg; ?>
			<?php if ($isManga): ?>
			<form action="../action/aksi_upload.php" method="POST" enctype="multipart/form-data" class="space-y-8">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8">
					<!-- Cover preview dan upload -->
					<div class="md:col-span-1 flex flex-col items-center justify-start">
						<div class="w-48 h-64 rounded-2xl shadow-xl border-4 border-pink-200 overflow-hidden mb-4 flex items-center justify-center bg-white">
							<span class="text-gray-400 italic">Preview Cover</span>
						</div>
						<div class="w-full max-w-xs flex flex-col items-center gap-3 bg-white/80 p-4 rounded-xl shadow">
							<label class="block text-gray-700 font-semibold mb-2" for="cover_manga">Upload Cover</label>
							<input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="file" id="cover_manga" name="cover_manga" accept="image/*" required>
						</div>
					</div>
					<!-- Form data manga -->
					<div class="md:col-span-2">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="judul_manga">Judul Manga</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="text" id="judul_manga" name="judul_manga" required>
							</div>
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="genre_manga">Genre</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="text" id="genre_manga" name="genre_manga" required>
							</div>
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="rating_manga">Rating</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" type="number" step="0.1" min="0" max="10" id="rating_manga" name="rating_manga" required>
							</div>
						</div>
						<div>
							<label class="block text-gray-700 font-semibold mb-2" for="synopsis_manga">Synopsis</label>
							<textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-pink-50" id="synopsis_manga" name="synopsis_manga" rows="4"></textarea>
						</div>
						<div class="mt-6">
							<label class="block text-gray-700 font-semibold mb-2" for="chapter">Upload Chapter (PDF/ZIP)</label>
							<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-400 outline-none bg-white" type="file" id="chapter" name="chapter" accept=".pdf,.zip" required>
						</div>
						<button type="submit" class="w-full py-3 rounded-full bg-pink-500 text-white font-bold text-lg shadow hover:bg-pink-600 transition-all mt-8">Tambah Manga</button>
					</div>
				</div>
			</form>
			<?php else: ?>
			<form action="../action/aksi_upload.php" method="POST" enctype="multipart/form-data" class="space-y-8">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start mb-8">
					<!-- Cover preview dan upload -->
					<div class="md:col-span-1 flex flex-col items-center justify-start">
						<div class="w-48 h-64 rounded-2xl shadow-xl border-4 border-indigo-200 overflow-hidden mb-4 flex items-center justify-center bg-white">
							<span class="text-gray-400 italic">Preview Cover</span>
						</div>
						<div class="w-full max-w-xs flex flex-col items-center gap-3 bg-white/80 p-4 rounded-xl shadow">
							<label class="block text-gray-700 font-semibold mb-2" for="foto">Upload Cover</label>
							<input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="file" id="foto" name="foto" accept="image/*" required>
						</div>
					</div>
					<!-- Form data anime -->
					<div class="md:col-span-2">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="judul">Judul Anime</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="text" id="judul" name="judul" required>
							</div>
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="genre">Genre</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="text" id="genre" name="genre" required>
							</div>
							<div>
								<label class="block text-gray-700 font-semibold mb-2" for="rating">Rating</label>
								<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" type="number" step="0.1" min="0" max="10" id="rating" name="rating" required>
							</div>
						</div>
						<div>
							<label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Synopsis</label>
							<textarea class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-indigo-50" id="deskripsi" name="deskripsi" rows="4"></textarea>
						</div>
						<div class="mt-6">
							<label class="block text-gray-700 font-semibold mb-2" for="episode">Upload Episode (bisa banyak)</label>
							<input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none bg-white" type="file" id="episode" name="episode[]" accept="video/*" multiple>
						</div>
						<button type="submit" class="w-full py-3 rounded-full bg-indigo-600 text-white font-bold text-lg shadow hover:bg-indigo-700 transition-all mt-8">Tambah Anime</button>
					</div>
				</div>
			</form>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
