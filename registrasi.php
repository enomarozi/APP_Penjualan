<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi | Aplikasi Pembelian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-success-subtle d-flex justify-content-center align-items-center vh-100">

<div class="card shadow" style="width: 22rem;">
    <div class="card-body">
        <h4 class="card-title text-center mb-4">Registrasi Aplikasi Pembelian</h4>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="admin" placeholder="Masukkan Username">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password1" value="password" placeholder="Masukkan password">
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password2" value="password" placeholder="Konfirmasi Password">
            </div>

            <button type="submit" class="btn btn-success w-100" name="registrasi" value="registrasi">
                Login
            </button>
            <?php
				require_once "koneksi.php";
				if($_POST['registrasi'] === "registrasi"){
					$username = $_POST['username'];
					$password1 = $_POST['password1'];
					$password2 = $_POST['password2'];
					$db = new Database();
					if(strlen($password1) == 8 && $password1 === $password2){
						$cek = $db->query("SELECT username FROM users WHERE username=? LIMIT 1",[$username]);
						if(!$cek){
							$password_hash = password_hash($password2 ,PASSWORD_DEFAULT);
							$db->execute("INSERT INTO users (username, password) VALUES (?, ?)",[$username, $password_hash]);
							$_SESSION['success'] = "Akun berhasil dibuat.";
							header("Location: login.php");
						}else{
							$_SESSION['faled'] = "Username akun sudah ada.";
						}
					}else{
						$_SESSION['faled'] = "Panjangan Password min 8 dan harus sama dengan konfirmasi password.";
					}

				}
			?>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php if(isset($_SESSION['success'])): ?>
			<script>
			    Swal.fire({
			        icon: 'success',
			        title: 'Berhasil!',
			        text: '<?= $_SESSION['success']; ?>',
			        timer: 1500,
			        showConfirmButton: false
			    });
			</script>
		<?php unset($_SESSION['success']); ?>
		<?php elseif (isset($_SESSION['failed'])): ?>
			<script>
		        Swal.fire({
		            icon: 'error',
		            title: 'Gagal!',
		            text: '<?= $_SESSION['failed']; ?>',
		            timer: 2000,
		            showConfirmButton: false
		        });
		    </script>
		<?php unset($_SESSION['failed']); ?> 
		<?php endif; ?>
        <p class="text-center text-muted mt-3 mb-0" style="font-size: 13px;">
            © 2025 Aplikasi Pembelian
        </p>
    </div>
</div>

</body>
</html>