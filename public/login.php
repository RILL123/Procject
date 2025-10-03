<?php
include '../action/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/login.js"></script>
</head>
<body class="relative min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-indigo-100 via-white to-indigo-200 overflow-hidden">
    <!-- Decorative background shapes -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-200 rounded-full opacity-30 blur-2xl z-0"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-300 rounded-full opacity-20 blur-2xl z-0"></div>
    <div class="w-full max-w-md bg-white/90 rounded-3xl shadow-2xl p-10 mt-8 animate-fade-in-up relative z-10 border border-indigo-100 backdrop-blur-md">
        <div class="flex flex-col items-center mb-6">
            <img src="../image/nimetv.png" alt="NimeTV Logo" class="w-20 h-20 rounded-full shadow-lg border-4 border-indigo-200 mb-2 object-cover">
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-1 tracking-tight drop-shadow">NimeTV</h1>
            <span class="text-sm text-indigo-400 font-semibold mb-2">Anime Streaming Platform</span>
        </div>
        <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Login Akun</h2>
        <form action="../action/aksi_login.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="username">Username</label>
                <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition-all duration-200 bg-white/80 placeholder-gray-400 hover:border-indigo-400" type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="username">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
                <div class="relative">
                    <input class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none pr-10 transition-all duration-200 bg-white/80 placeholder-gray-400 hover:border-indigo-400" type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none">
                        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-bold text-lg shadow-lg hover:scale-105 hover:from-indigo-600 hover:to-indigo-800 focus:ring-2 focus:ring-indigo-400 transition-all duration-200">Login</button>
        </form>
        <div class="mt-6 text-center text-gray-500 text-sm">
            Belum punya akun? <a href="registrasi.php" class="text-indigo-600 hover:underline font-semibold">Daftar</a>
        </div>
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