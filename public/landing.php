<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/landing.js"></script>
    <style>
      html {
        scroll-behavior: smooth;
      }
    </style>
</head>

<body>

<!-- Navbar Sederhana Tailwind -->
<nav class="bg-white border-b border-gray-200 fixed inset-x-0 top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <div class="flex items-center">
        <a href="#" class="flex-shrink-0 flex items-center">
          <span class="ml-2 font-bold text-xl text-gray-800">NimeTV</span>
        </a>
      </div>
      <div class="hidden md:flex space-x-8">
  <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium" id="homeNav">Home</a>
  <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium" id="aboutNav">About</a>
  <a href="#services" class="text-gray-700 hover:text-indigo-600 font-medium" id="servicesNav">Services</a>
  <a href="contact.php" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>
  <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Community</a>
      </div>
      <div class="md:hidden">
        <!-- Icon menu untuk mobile, bisa dikembangkan -->
        <button type="button" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <!-- Akun Icon -->
      <div class="ml-4 relative">
        <button id="accountBtn" type="button" class="flex items-center focus:outline-none">
          <span class="sr-only">Akun</span>
          <svg class="w-8 h-8 rounded-full border-2 border-indigo-600 text-gray-700 bg-white hover:bg-indigo-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </button>
        <!-- Notifikasi login -->
        <div id="loginNotif" class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50 animate-fade-in">
          <p class="text-gray-800 font-semibold mb-2">Login Diperlukan</p>
          <p class="text-gray-600 text-sm">Silakan login untuk mengakses fitur akun.</p>
          <div class="mt-4">
            <a href="login.php" class="block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">Login</a>
        </div>
      </div>
    <style>
      @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
      }
      .animate-fade-in {
        animation: fade-in 0.2s ease;
      }
    </style>
    </div>
  </div>
</nav>
<div class="h-16"></div>
</nav>


<!-- Section dengan background foto dan kata-kata di kiri -->
<section id="home" class="relative flex items-center min-h-[600px] bg-gray-200 overflow-hidden" style="background-image: url('../image/background.jpg'); background-size:cover; background-position:center;">
  <!-- Overlay gradasi -->
  <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>
  <div class="relative z-10 max-w-2xl ml-8 md:ml-16 p-10 rounded-3xl shadow-2xl bg-white/20 backdrop-blur-xl animate-fade-in-up border border-white/30">
    <div class="flex items-center mb-4">
      <svg class="w-12 h-12 text-indigo-400 mr-3 drop-shadow-lg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
      <h1 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg">Selamat Datang di <span class="text-indigo-400">NimeTV</span></h1>
    </div>
    <p class="text-xl md:text-2xl text-indigo-100 mb-8 font-medium drop-shadow">Nikmati berbagai konten anime menarik dan terbaru hanya di sini. Temukan hiburan favoritmu buat nonton atau streaming sekarang!</p>
    <a href="login.php" class="inline-block px-10 py-4 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-700 text-white text-xl font-bold shadow-xl hover:from-indigo-700 hover:to-indigo-500 hover:scale-105 transition-all duration-300 border-2 border-white/30">Lihat Selengkapnya</a>
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
</section>

<!-- Section About -->
<section id="about" class="py-24 bg-gradient-to-b from-white to-indigo-50">
  <div class="max-w-5xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-4xl font-extrabold text-indigo-700 mb-4 drop-shadow-lg">Tentang <span class="text-indigo-500">NimeTV</span></h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">NimeTV adalah platform streaming anime yang menyediakan berbagai judul anime terbaru dan terpopuler. Kami berkomitmen untuk memberikan pengalaman menonton terbaik dengan kualitas video tinggi dan update episode tercepat.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Koleksi Anime Lengkap</h3>
        <p class="text-gray-600 text-center">Ribuan judul anime dari berbagai genre, selalu update setiap minggu.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17a2.25 2.25 0 004.5 0m-7.5-4.5V9a6 6 0 1112 0v3.5M5.25 12.5h13.5"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Streaming Tanpa Buffering</h3>
        <p class="text-gray-600 text-center">Teknologi streaming cepat dan stabil untuk pengalaman menonton tanpa gangguan.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4.13V7a4 4 0 10-8 0v3m8 0a4 4 0 01-8 0"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Komunitas Penggemar</h3>
        <p class="text-gray-600 text-center">Bergabung dengan komunitas anime, diskusi, dan event seru setiap bulan.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Bookmark & Rekomendasi</h3>
        <p class="text-gray-600 text-center">Simpan anime favorit dan dapatkan rekomendasi sesuai minatmu.</p>
      </div>
    </div>
  </div>

<!-- Section Services -->
<section id="services" class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-4xl font-extrabold text-indigo-700 mb-4 drop-shadow-lg">Layanan <span class="text-indigo-500">NimeTV</span></h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai layanan untuk mendukung pengalaman menonton anime terbaik bagi para pengguna kami.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-indigo-50 rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A2 2 0 0020 6.382V5a2 2 0 00-2-2H6a2 2 0 00-2 2v1.382a2 2 0 00.447 1.342L9 10m6 0v4a2 2 0 01-2 2H7a2 2 0 01-2-2v-4m11 0l-7 4m0 0v4a2 2 0 002 2h6a2 2 0 002-2v-4m-7 0l7-4"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Streaming Anime HD</h3>
        <p class="text-gray-600 text-center">Tonton anime favoritmu dengan kualitas tinggi dan subtitle Indonesia/English.</p>
      </div>
      <div class="bg-indigo-50 rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Download Anime</h3>
        <p class="text-gray-600 text-center">Unduh episode anime favoritmu dan tonton kapan saja tanpa koneksi internet.</p>
      </div>
      <div class="bg-indigo-50 rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition-transform duration-300">
        <div class="bg-indigo-100 rounded-full p-4 mb-4">
          <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4.13V7a4 4 0 10-8 0v3m8 0a4 4 0 01-8 0"/></svg>
        </div>
        <h3 class="text-xl font-semibold text-indigo-700 mb-2">Forum & Komunitas</h3>
        <p class="text-gray-600 text-center">Diskusi, review, dan event komunitas anime bersama member NimeTV lainnya.</p>
      </div>
    </div>
  </div>
</section>

<footer class="bg-indigo-800 text-white py-10 mt-16 border-t border-indigo-900">
  <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex items-center space-x-3">
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-700 shadow-lg">
            <svg class="w-7 h-7" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="32" height="32" rx="16" fill="url(#nime-logo-bg)"/>
              <defs>
                <linearGradient id="nime-logo-bg" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#6366F1"/>
                  <stop offset="1" stop-color="#3730A3"/>
                </linearGradient>
              </defs>
              <text x="50%" y="58%" text-anchor="middle" fill="#fff" font-size="18" font-family="Arial Black,Arial,sans-serif" font-weight="bold" dy=".1em">N</text>
            </svg>
          </span>
          <span class="font-bold text-lg tracking-wide">NimeTV</span>
    </div>
    <div class="text-center text-indigo-200 text-sm">&copy; 2025 NimeTV. All rights reserved.</div>
    <div class="flex space-x-4">
      <a href="#" class="hover:text-yellow-300 transition-colors" title="Instagram"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.5" y2="6.5"/></svg></a>
      <a href="#" class="hover:text-yellow-300 transition-colors" title="Twitter"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0022.4 1.64a9.09 9.09 0 01-2.88 1.1A4.52 4.52 0 0016.11 0c-2.5 0-4.52 2.02-4.52 4.52 0 .35.04.7.11 1.03C7.69 5.4 4.07 3.7 1.64 1.15c-.38.65-.6 1.4-.6 2.2 0 1.52.77 2.86 1.94 3.65A4.48 4.48 0 01.96 6v.06c0 2.13 1.52 3.91 3.54 4.31-.37.1-.76.16-1.16.16-.28 0-.55-.03-.81-.08.56 1.74 2.17 3.01 4.09 3.05A9.05 9.05 0 010 19.54a12.8 12.8 0 006.92 2.03c8.3 0 12.85-6.88 12.85-12.85 0-.2 0-.39-.01-.58A9.22 9.22 0 0024 4.59a9.1 9.1 0 01-2.6.71A4.48 4.48 0 0023 3z"/></svg></a>
      <a href="#" class="hover:text-yellow-300 transition-colors" title="YouTube"><svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-2C18.88 4 12 4 12 4s-6.88 0-8.59.42a2.78 2.78 0 00-1.95 2A29.94 29.94 0 001 12a29.94 29.94 0 00.46 5.58 2.78 2.78 0 001.95 2C5.12 20 12 20 12 20s6.88 0 8.59-.42a2.78 2.78 0 001.95-2A29.94 29.94 0 0023 12a29.94 29.94 0 00-.46-5.58zM10 15V9l6 3-6 3z"/></svg></a>
    </div>
  </div>
</footer>
</body>

</html>