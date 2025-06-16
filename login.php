<?php
session_start();
include_once("inc_koneksi.php");

if (isset($_SESSION['admin_username'])) {
    header("Location: admin_depan.php");
    exit();
}

$username = "";
$password = "";
$err = "";

// Saat tombol login ditekan
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $err = "⚠️ Username dan password tidak boleh kosong.";
    } else {
        // Lindungi dari SQL Injection
        $username_safe = mysqli_real_escape_string($koneksi, $username);
        $password_safe = mysqli_real_escape_string($koneksi, $password);

        $sql = "SELECT * FROM user 
                WHERE username='$username_safe' 
                AND password='$password_safe' 
                LIMIT 1";
        $q = mysqli_query($koneksi, $sql);
        $r = mysqli_fetch_assoc($q);

        if ($r) {
            $_SESSION['admin_username'] = $r['username'];
            $_SESSION['admin_role'] = $r['role'];
            $_SESSION['admin_akses'] = [$r['role']]; // hanya 1 role
            header("Location: admin_depan.php");
            exit();
        } else {
            $err = "❌ Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Bakso Mataram</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="app">
    <h1>🔐 Login Admin</h1>

    <?php if ($err): ?>
        <div style="color:red; margin-bottom:10px;"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>👤 Username:</label><br>
        <input type="text" name="username" class="input" value="<?= htmlspecialchars($username) ?>"><br><br>

        <label>🔒 Password:</label><br>
        <input type="password" name="password" class="input" id="pass"><br><br>

        <input type="submit" name="login" value="Masuk Ke Sistem">
    </form>
</div>
</body>
</html>
