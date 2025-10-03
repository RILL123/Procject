<?php
include '../action/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-white to-indigo-100 min-h-screen flex flex-col justify-center items-center">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-10 mt-8 animate-fade-in-up">
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-6 text-center">Registrasi Akun</h1>
        <form action="../action/aksi_registrasi.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="username">Username</label>
                <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" type="text" id="us
                ername" name="username" placeholder="Masukkan username" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="nama_user">Nama Lengkap</label>
                <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" type="text" id="nama_user" name="nama_user" placeholder="Masukkan nama lengkap" required>
            </div>
                        <div>
                                <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
                                <div class="relative">
                                    <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none pr-10" type="password" id="password" name="password" placeholder="Masukkan password" required>
                                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none">
                                        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                </div>
                        </div>
                        <div>
                                <label class="block text-gray-700 font-semibold mb-2" for="confirm">Konfirmasi Password</label>
                                <div class="relative">
                                    <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none pr-10" type="password" id="confirm" name="confirm" placeholder="Ulangi password" required>
                                    <button type="button" onclick="togglePassword('confirm', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none">
                                        <svg id="icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>
                                </div>
                        </div>
            <button type="submit" class="w-full py-3 rounded-full bg-indigo-600 text-white font-bold text-lg shadow hover:bg-indigo-700 transition-all">Daftar</button>
        </form>
        <div class="mt-6 text-center text-gray-500 text-sm">
            Sudah punya akun? <a href="login.php" class="text-indigo-600 hover:underline">Login</a>
        </div>
    </div>
        <script>
            function togglePassword(id, btn) {
                const input = document.getElementById(id);
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.querySelector('svg').classList.add('text-indigo-600');
                } else {
                    input.type = 'password';
                    btn.querySelector('svg').classList.remove('text-indigo-600');
                }
            }
        </script>
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
