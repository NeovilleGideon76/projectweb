<?php
session_start();
// Cek jika pengguna belum login, redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Mengambil username dari sesi
$username = $_SESSION['username'];

// Proses upload berkas jika ada yang diunggah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tentukan direktori tujuan untuk menyimpan berkas yang diunggah
    $targetDir = "berkas/";

    // Dapatkan informasi berkas yang diunggah oleh pengguna
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    // Periksa apakah berkas sudah diunggah dengan sukses
    if (is_uploaded_file($fileTmp)) {
        // Periksa jenis berkas yang diperbolehkan (contoh: hanya gambar)
        $allowedTypes = array('image/jpeg', 'image/png');
        if (!in_array($fileType, $allowedTypes)) {
            echo "Jenis berkas tidak diizinkan. Harap unggah gambar (JPG, PNG).";
        } elseif ($fileSize > 5000000) { // Batasan ukuran berkas (contoh: 5 MB)
            echo "Ukuran berkas terlalu besar. Maksimal 5 MB.";
        } else {
            // Tentukan path lengkap berkas tujuan
            $targetPath = $targetDir . $fileName;

            // Pindahkan berkas yang diunggah ke direktori tujuan
            if (move_uploaded_file($fileTmp, $targetPath)) {
                echo "Berkas berhasil diunggah.";
            } else {
                echo "Terjadi kesalahan saat mengunggah berkas.";
            }
        }
    } else {
        echo "Terjadi kesalahan saat mengunggah berkas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unggah Berkas</title>
    <link rel="stylesheet" href="upload.css"/>
</head>
<body>
    <h1>Unggah Berkas</h1>
    <a href="/home.html">Home</a>
    <br><br>
    <form method="POST" enctype="multipart/form-data" action="upload.php">
        <input type="file" name="file" required>
        <br><br>
        <input type="submit" value="Unggah">
    </form>
</body>
</html>