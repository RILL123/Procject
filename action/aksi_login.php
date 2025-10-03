
<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$password = isset($_POST['password']) ? trim($_POST['password']) : '';

	$query = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
	$result = mysqli_query($koneksi, $query);
	$user = mysqli_fetch_assoc($result);

	if ($user && $password === $user['password']) {
		$_SESSION['user'] = $user['username'];
		if (isset($user['level']) && $user['level'] === 'admin') {
			header('Location: ../public/admin.php');
			exit();
		} else if (isset($user['level']) && $user['level'] === 'pengguna') {
			header('Location: ../public/dashboard.php');
			exit();
		} else {
			echo '<script>alert("Role tidak dikenali!"); window.location.href = "../public/login.php";</script>';
			exit();
		}
	}
    else {
		echo '<script>alert("Username atau password salah!"); window.location.href = "../public/login.php";</script>';
		exit();
	}
} else {
	header('Location: ../public/login.php');
	exit();

}

