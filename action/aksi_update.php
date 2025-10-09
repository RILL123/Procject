<?php
include 'koneksi.php';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Update data anime
if (isset($_POST['update_data'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $rating = floatval($_POST['rating']);
    $synopsis = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $sql = "UPDATE anime SET judul_anime='$judul', genre='$genre', rating='$rating', synopsis='$synopsis' WHERE id_anime=$id";
    mysqli_query($koneksi, $sql);
    header("Location: ../public/update.php?id=$id&msg=updated");
    exit;
}

// Update cover
if (isset($_POST['update_cover']) && isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
    // name the cover based on the anime title
    $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id LIMIT 1");
    $anime = mysqli_fetch_assoc($animeQ);
    if ($anime) {
        $orig = basename($_FILES['cover']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safeTitle = preg_replace('/[^a-zA-Z0-9._-]/', '_', $anime['judul_anime']);
        $newName = $safeTitle . ($ext ? ('.' . $ext) : '');
        $target = '../image/' . $newName;
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target)) {
            // delete old cover if exists
            if (!empty($anime['image'])) {
                $old = '../image/' . $anime['image'];
                if (is_file($old)) unlink($old);
            }
            $sql = "UPDATE anime SET image='" . mysqli_real_escape_string($koneksi, $newName) . "' WHERE id_anime=$id";
            mysqli_query($koneksi, $sql);
            header("Location: ../public/update.php?id=$id&msg=cover_updated");
            exit;
        } else {
            header("Location: ../public/update.php?id=$id&msg=cover_failed");
            exit;
        }
    }
}

// Tambah episode
if (isset($_POST['tambah_episode']) && isset($_FILES['episode_file']) && $_FILES['episode_file']['error'] == 0) {
    $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id LIMIT 1");
    $anime = mysqli_fetch_assoc($animeQ);
    if ($anime) {
        $folder = '../video/' . $anime['judul_anime'];
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $target = $folder . '/' . basename($_FILES['episode_file']['name']);
        if (move_uploaded_file($_FILES['episode_file']['tmp_name'], $target)) {
            header("Location: ../public/update.php?id=$id&msg=episode_uploaded");
            exit;
        } else {
            header("Location: ../public/update.php?id=$id&msg=episode_failed");
            exit;
        }
    }
}

// Hapus episode
if (isset($_POST['hapus_episode'])) {
    $animeQ = mysqli_query($koneksi, "SELECT * FROM anime WHERE id_anime = $id LIMIT 1");
    $anime = mysqli_fetch_assoc($animeQ);
    if ($anime) {
        $folder = '../video/' . $anime['judul_anime'];
        $file = $folder . '/' . basename($_POST['hapus_episode']);
        if (is_file($file)) {
            if (unlink($file)) {
                header("Location: ../public/update.php?id=$id&msg=episode_deleted");
                exit;
            } else {
                header("Location: ../public/update.php?id=$id&msg=episode_delete_failed");
                exit;
            }
        }
    }
}
