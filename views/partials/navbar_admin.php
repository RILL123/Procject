<aside class="w-64 bg-gradient-to-b from-white via-indigo-50 to-purple-100 border-r border-indigo-200 shadow-2xl flex flex-col py-10 px-7 min-h-screen sticky left-0 top-0 z-30">
    <div class="flex items-center gap-3 mb-12">
        <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-400 shadow-xl overflow-hidden">
            <img src="../image/nimetv.png" alt="nimetv" class="object-contain w-12 h-12" />
        </span>
        <span class="text-2xl font-extrabold text-indigo-700 tracking-tight drop-shadow">NimeTV <span class="text-purple-500">Admin</span></span>
    </div>
    <nav class="flex flex-col gap-2 mt-4">
        <a href="admin.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-semibold text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"/></svg>
            Dashboard
        </a>
        <a href="upload.php" class="flex items-center px-4 py-2 bg-indigo-200 text-indigo-900 font-bold rounded shadow hover:bg-indigo-300 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Anime
        </a>
          <a href="upload.php?type=manga" class="flex items-center px-4 py-2 bg-pink-200 text-pink-900 font-bold rounded shadow hover:bg-pink-300 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Manga
                    </a>
        <a href="upload.php?type=novel" class="flex items-center px-4 py-2 bg-green-200 text-green-900 font-bold rounded shadow hover:bg-green-300 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Novel
        </a>
        <a href="../action/upload_berita.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-semibold text-indigo-700 hover:bg-indigo-100 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Berita
        </a>
        <a href="logout.php" class="flex items-center gap-2 px-4 py-2 rounded-xl font-semibold text-red-600 hover:bg-red-100 transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
            Logout
        </a>
    </nav>
    <div class="mt-auto pt-10 text-xs text-gray-400 text-center select-none">&copy; 2025 <span class="font-bold text-indigo-400">NimeTV</span>. All rights reserved.</div>
</aside>