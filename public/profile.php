<?php
// Halaman profil user: tampilkan nama_user, foto profil, banner, dan fitur upload/ubah foto profil & banner
session_start();
include '../action/koneksi.php';

// Cek login
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}
$username = $_SESSION['user'];

// Proses upload foto profil, banner, bio, dan genre favorit
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data user lama
  $userQ = mysqli_query($koneksi, "SELECT pfp, banner FROM user WHERE username='$username' LIMIT 1");
  $userOld = mysqli_fetch_assoc($userQ);
  // Foto profil
  if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $namaFile = 'profile_' . $username . '.' . $ext;
    $tujuan = '../image/' . $namaFile;
    if (!empty($userOld['pfp']) && $userOld['pfp'] !== 'default_profile.png' && file_exists('../image/' . $userOld['pfp'])) {
      @unlink('../image/' . $userOld['pfp']);
    }
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $tujuan)) {
      $sql = "UPDATE user SET pfp='$namaFile' WHERE username='$username'";
      if (mysqli_query($koneksi, $sql)) {
        $msg = 'Foto profil berhasil diubah!';
      } else {
        $msg = 'Gagal update database: ' . mysqli_error($koneksi);
      }
    } else {
      $msg = 'Gagal upload file.';
    }
  }
  // Banner profil
  if (isset($_FILES['banner']) && !empty($_FILES['banner']['name'])) {
    $ext = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
    $namaFile = 'banner_' . $username . '.' . $ext;
    $tujuan = '../image/' . $namaFile;
    if (!empty($userOld['banner']) && $userOld['banner'] !== 'default_banner.png' && file_exists('../image/' . $userOld['banner'])) {
      @unlink('../image/' . $userOld['banner']);
    }
    if (move_uploaded_file($_FILES['banner']['tmp_name'], $tujuan)) {
      $sql = "UPDATE user SET banner='$namaFile' WHERE username='$username'";
      if (mysqli_query($koneksi, $sql)) {
        $msg = 'Banner berhasil diubah!';
      } else {
        $msg = 'Gagal update database: ' . mysqli_error($koneksi);
      }
    } else {
      $msg = 'Gagal upload banner.';
    }
  }
  // Bio & genre favorit
  $bio = mysqli_real_escape_string($koneksi, $_POST['bio'] ?? '');
  $genre = mysqli_real_escape_string($koneksi, $_POST['fav'] ?? '');
  if (isset($_POST['bio']) || isset($_POST['fav'])) {
    $sql = "UPDATE user SET bio='$bio', fav='$genre' WHERE username='$username'";
    if (mysqli_query($koneksi, $sql)) {
      $msg = 'Profil berhasil diperbarui!';
    } else {
      $msg = 'Gagal update profil: ' . mysqli_error($koneksi);
    }
  }
}

// Ambil data user
$userQ = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' LIMIT 1");
$user = mysqli_fetch_assoc($userQ);
$foto = $user['pfp'] ?? 'default_profile.png';
$banner = $user['banner'] ?? 'default_banner.png';
$nama = $user['nama_user'] ?? $username;
$bio = $user['bio'] ?? '';
$genre_fav = $user['fav'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil | NimeTV</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-100 via-white to-purple-100 min-h-screen flex flex-col">
  <?php include '../views/partials/navbar_user.php'; ?>
  <div class="h-16"></div>
  <main class="flex-1 flex flex-col items-center py-10">
    <div class="w-full max-w-2xl mx-auto bg-white/90 rounded-3xl shadow-2xl p-0 border border-indigo-100 flex flex-col items-center gap-0 overflow-hidden">
      <!-- Banner -->
      <div class="w-full h-40 md:h-56 bg-gradient-to-tr from-indigo-200 via-white to-purple-200 relative flex items-center justify-center">
        <img src="../image/<?php echo htmlspecialchars($banner); ?>" alt="Banner" class="absolute inset-0 w-full h-full object-cover object-center z-0">
        <form action="" method="post" enctype="multipart/form-data" class="absolute right-4 bottom-4 z-10 flex items-center gap-2">
          <input type="file" name="banner" id="bannerInput" accept="image/*" class="hidden" onchange="this.form.submit()">
          <label for="bannerInput" class="px-4 py-2 rounded-full bg-indigo-600 text-white font-bold shadow hover:bg-purple-600 cursor-pointer transition-all text-xs">Ubah Banner</label>
        </form>
      </div>
      <!-- Foto profil -->
      <div class="-mt-16 mb-2 z-10 relative flex flex-col items-center">
        <img src="../image/<?php echo htmlspecialchars($foto); ?>" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-200 shadow">
        <form action="" method="post" enctype="multipart/form-data" class="mt-2 flex flex-col items-center gap-2">
          <input type="file" name="foto" id="fotoInput" accept="image/*" class="hidden" onchange="this.form.submit()">
          <label for="fotoInput" class="px-5 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-bold shadow hover:scale-105 transition-all cursor-pointer">Ubah Foto Profil</label>
        </form>
      </div>
      <div class="text-2xl font-extrabold text-indigo-700 mb-1 mt-2 drop-shadow-lg"><?php echo htmlspecialchars($nama); ?></div>
      <!-- Bio dan Genre Favorit tampil rapi -->
      <div class="w-full flex flex-col md:flex-row gap-4 px-8 mt-2 mb-4" id="bioView">
        <div class="flex-1 flex flex-col items-center md:items-start">
          <span class="block text-xs font-semibold text-gray-500 mb-1">Bio</span>
          <div class="w-full min-h-[48px] px-4 py-3 rounded-xl border border-indigo-100 bg-white/80 shadow-inner text-indigo-800 font-semibold text-base text-center md:text-left">
            <?php echo $bio ? nl2br(htmlspecialchars($bio)) : '<span class=\'text-gray-400\'>Belum ada bio</span>'; ?>
          </div>
        </div>
        <div class="flex-1 flex flex-col items-center md:items-start">
          <span class="block text-xs font-semibold text-gray-500 mb-1">Genre Favorit</span>
          <?php if ($genre_fav): ?>
            <span class="inline-block px-4 py-1 rounded-full bg-gradient-to-r from-indigo-200 to-purple-200 text-indigo-700 font-bold text-xs shadow mb-1">Favorit: <?php echo htmlspecialchars($genre_fav); ?></span>
          <?php else: ?>
            <span class="text-gray-400">Belum diisi</span>
          <?php endif; ?>
        </div>
      </div>
      <div class="w-full flex justify-end px-8 mb-2" id="editBioBtnWrap">
        <button type="button" id="editBioBtn" class="px-6 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-bold shadow hover:scale-105 transition-all">Edit Bio</button>
      </div>
      <form action="" method="post" class="w-full flex flex-col md:flex-row gap-4 px-8 mb-2 items-end hidden" id="bioEditForm">
        <div class="flex-1 flex flex-col gap-1">
          <label class="block text-xs font-semibold text-gray-600 mb-1">Edit Bio</label>
          <textarea name="bio" rows="2" maxlength="200" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-400 outline-none resize-none bg-white/70 shadow-inner text-indigo-800 font-semibold text-base" placeholder="Tulis bio singkat..." style="min-height:56px;"><?php echo htmlspecialchars($bio); ?></textarea>
        </div>
        <div class="flex-1 flex flex-col gap-1">
          <label class="block text-xs font-semibold text-gray-600 mb-1">Edit Genre Favorit</label>
          <input type="text" name="fav" maxlength="100" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:ring-2 focus:ring-indigo-400 outline-none bg-white/70 shadow-inner text-indigo-800 font-semibold text-base" placeholder="Contoh: Action, Romance" value="<?php echo htmlspecialchars($genre_fav); ?>">
        </div>
        <div class="flex flex-col gap-2 items-center">
          <button type="submit" class="h-12 mt-2 px-8 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-extrabold shadow-lg hover:scale-105 hover:shadow-2xl transition-all text-lg tracking-wide whitespace-nowrap">Simpan</button>
          <button type="button" id="cancelBioBtn" class="px-4 py-2 rounded-full bg-gray-200 text-indigo-700 font-bold shadow hover:bg-gray-300 transition-all">Batal</button>
        </div>
      </form>
      <script>
        const editBioBtn = document.getElementById('editBioBtn');
        const bioView = document.getElementById('bioView');
        const bioEditForm = document.getElementById('bioEditForm');
        const editBioBtnWrap = document.getElementById('editBioBtnWrap');
        const cancelBioBtn = document.getElementById('cancelBioBtn');
        editBioBtn.addEventListener('click', function() {
          bioView.classList.add('hidden');
          editBioBtnWrap.classList.add('hidden');
          bioEditForm.classList.remove('hidden');
        });
        cancelBioBtn.addEventListener('click', function(e) {
          e.preventDefault();
          bioView.classList.remove('hidden');
          editBioBtnWrap.classList.remove('hidden');
          bioEditForm.classList.add('hidden');
        });
      </script>
      <?php if ($msg): ?><div class="text-sm text-<?php echo strpos($msg,'berhasil')!==false?'green':'red'; ?>-600 mb-2 animate-fade-in-up"><?php echo $msg; ?></div><?php endif; ?>
      <a href="logout.php" class="mt-6 mb-6 px-7 py-3 rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white font-extrabold shadow-lg hover:scale-105 hover:shadow-2xl transition-all text-lg tracking-wide">Logout</a>
    <style>
      @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-in-up {
        animation: fade-in-up 0.8s cubic-bezier(.4,0,.2,1) both;
      }
    </style>
    </div>
  </main>
  <footer class="bg-white text-gray-600 py-8 mt-12 border-t">
    <div class="max-w-7xl mx-auto px-4 text-center">
      &copy; 2025 NimeTV. All rights reserved.
    </div>
  </footer>
</body>
</html>
