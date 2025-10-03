 <nav class="bg-white/80 border-b border-indigo-100 fixed inset-x-0 top-0 z-50 shadow-sm backdrop-blur">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex items-center gap-3">
            <img src="../image/nimetv.png" alt="NimeTV Logo" class="w-10 h-10 object-contain rounded-xl shadow-md">
            <span class="ml-2 font-extrabold text-2xl text-indigo-700 tracking-tight drop-shadow">NimeTV</span>
          </div>
          <div class="hidden md:flex space-x-8">
            <a href="dashboard.php" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">Home</a>
            <a href="news.php" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">News</a>
            <a href="#services" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">Services</a>
            <a href="contact.php" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">Contact</a>
            <a href="#Manga" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">Manga</a>
            <a href="Novel.php" class="text-indigo-700 hover:text-purple-600 font-semibold transition-all">Novel</a>
          </div>
          <?php
            // Ambil foto profil user dari session
            $pfp = 'default_profile.png';
            if (isset($_SESSION['user'])) {
              $username = $_SESSION['user'];
              $koneksi = $koneksi ?? (include __DIR__ . '/../../action/koneksi.php');
              $q = mysqli_query($koneksi, "SELECT pfp FROM user WHERE username='$username' LIMIT 1");
              if ($q && ($row = mysqli_fetch_assoc($q))) {
                if (!empty($row['pfp'])) $pfp = $row['pfp'];
              }
            }
          ?>
          <a href="profile.php" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-indigo-500 bg-white text-indigo-700 hover:bg-indigo-50 focus:outline-none transition-all shadow" title="Akun">
            <img src="../image/<?php echo htmlspecialchars($pfp); ?>" alt="Akun" class="w-9 h-9 rounded-full object-cover">
          </a>
        </div>
      </div>
    </nav>