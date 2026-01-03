<?php
session_start();
require_once "koneksi.php";

if (isset($_POST['registrasi'])) {
    $username  = trim($_POST['username']);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if (strlen($password1) >= 8 && $password1 === $password2) {
        $db = new Database();
        $cek = $db->query(
            "SELECT username FROM users WHERE username = ? LIMIT 1",
            [$username]
        );

        if (!$cek) {
            $password_hash = password_hash($password2, PASSWORD_DEFAULT);
            $db->execute(
                "INSERT INTO users (username, password) VALUES (?, ?)",
                [$username, $password_hash]
            );
            $_SESSION['success'] = "Akun berhasil dibuat.";
        } else {
            $_SESSION['failed'] = "Username sudah terdaftar.";
        }
    } else {
        $_SESSION['failed'] = "Password minimal 8 karakter dan harus sama.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi | Aplikasi Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-success-subtle d-flex justify-content-center align-items-center min-vh-100">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= $_SESSION['success']; ?>',
        timer: 1500,
        showConfirmButton: false
    });
});
</script>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['failed'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '<?= $_SESSION['failed']; ?>',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
<?php unset($_SESSION['failed']); endif; ?>

<div class="card shadow" style="width: 22rem;">
    <div class="card-body">
        <h4 class="card-title text-center mb-4">Registrasi Aplikasi Pembelian</h4>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password2" required>
            </div>

            <button type="submit" name="registrasi" class="btn btn-success w-100">
                Registrasi
            </button>
            <p class="text-center mt-3 mb-0">
			    Sudah punya akun?
			    <a href="login.php">Login di sini</a>
			</p>
        </form>

        <p class="text-center text-muted mt-3 mb-0" style="font-size: 13px;">
            © 2025 Aplikasi Pembelian
        </p>
    </div>
</div>

</body>
</html>
