<?php
session_start();
require_once "koneksi.php";

$error = null;

if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new Database();
    $user = $db->query(
        "SELECT id, username, password FROM users WHERE username=? LIMIT 1",
        [$username]
    );

    if ($user && password_verify($password, $user[0]['password'])) {
        $_SESSION['login']     = true;
        $_SESSION['user_id']   = $user[0]['id'];
        $_SESSION['username']  = $user[0]['username'];

        header('Location: index.php');
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Aplikasi Pembelian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success-subtle d-flex flex-column justify-content-center align-items-center min-vh-100">
<div class="card shadow" style="width: 22rem;">
    <div class="card-body">
        <h4 class="card-title text-center mb-4">Login Aplikasi Pembelian</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="admin" placeholder="Masukkan username">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" value="password" placeholder="Masukkan password">
            </div>

            <button type="submit" class="btn btn-success w-100">
                Login
            </button>
            <p class="text-center mt-3 mb-0">
                Belum punya akun?
                <a href="login.php">Registrasi</a>
            </p>
        </form>
        <p class="text-center text-muted mt-3 mb-0" style="font-size: 13px;">
            © 2025 Aplikasi Pembelian
        </p>
    </div>
</div>
<div class="mb-3" style="min-height: 60px; color: red;">
    <?php if ($error): ?>
        <div class="alert text-center mb-0">
            <?= $error; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
