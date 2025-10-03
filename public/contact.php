<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak | NimeTV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/contact.js"></script>
</head>
<body class="bg-gradient-to-b from-white to-indigo-50 min-h-screen flex flex-col">
        <?php include_once __DIR__ . '/../views/partials/navbar_user.php'; ?>
        <div class="h-16"></div>
        <main class="flex-1 flex items-center justify-center py-16">
            <section class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-10 mt-8 animate-fade-in-up">
                <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700 mb-6 text-center">Kontak Kami</h1>
                <p class="text-gray-600 text-lg mb-8 text-center">Punya pertanyaan, saran, atau ingin bekerja sama? Hubungi kami melalui form di bawah ini atau lewat email kami!</p>
                <form class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" for="name">Nama</label>
                        <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" type="text" id="name" name="name" placeholder="Nama Anda" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                        <input class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" type="email" id="email" name="email" placeholder="Email Anda" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2" for="message">Pesan</label>
                        <textarea class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 outline-none" id="message" name="message" rows="4" placeholder="Tulis pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="w-full py-3 rounded-full bg-indigo-600 text-white font-bold text-lg shadow hover:bg-indigo-700 transition-all">Kirim Pesan</button>
                </form>
                <div class="mt-8 text-center text-gray-500">
                    <span class="mr-2">Atau hubungi kami di:</span>
                    <a href="mailto:support@nimetv.com" class="text-indigo-600 hover:underline">support@nimetv.com</a>
                </div>
            </section>
        </main>
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