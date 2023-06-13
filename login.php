<?php
session_start();

// Cek jika pengguna sudah login, redirect ke halaman home
if (isset($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}

// Cek jika ada data login yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulasikan validasi login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh validasi sederhana
    if ($username === 'admin' && $password === '1') {
        // Set session
        $_SESSION['username'] = $username;

        // Redirect ke halaman home
        header("Location: index.html");
        exit;
    } else {
      $loginError = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($loginError)) { ?>
        <p class = "error"> <?php echo $loginError; ?></p>
    <?php } ?>
    <form method="POST" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required>
        <br><br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
