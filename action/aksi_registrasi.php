<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $nama_user = trim($_POST['nama_user'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if ($password !== $confirm) {
        echo '<script>alert("Password tidak sama!"); window.location.href = "../public/registrasi.php";</script>';
        exit();
    }

    // Cek username sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo '<script>alert("Username sudah terdaftar!"); window.location.href = "../public/registrasi.php";</script>';
        exit();
    }

    // Simpan user baru (password plain, ganti ke hash jika ingin lebih aman)
    $sql = "INSERT INTO user (username, nama_user, password) VALUES ('$username', '$nama_user', '$password')";
    if (mysqli_query($koneksi, $sql)) {
        echo '<script>alert("Registrasi berhasil! Silakan login."); window.location.href = "../public/login.php";</script>';
    } else {
        echo '<script>alert("Registrasi gagal!"); window.location.href = "../public/registrasi.php";</script>';
    }
    exit();
}
?>
