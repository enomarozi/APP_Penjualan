<?php
session_start();
if($_SESSION['login'] !== 1 && empty($_SESSION['username'])){
    $_SESSION = [];
    header("location: logout.php");
}
require_once "koneksi.php";
$db = new Database();

if (isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {

    $userId          = $_SESSION['user_id'];
    $oldPassword     = $_POST['old_password'];
    $newPassword     = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $user = $db->query(
        "SELECT password FROM users WHERE id=? LIMIT 1",
        [$userId]
    );

    if (!$user) {
        $_SESSION['failed'] = "User tidak ditemukan.";
    }
    elseif (!password_verify($oldPassword, $user[0]['password'])) {
        $_SESSION['failed'] = "Password lama salah.";
    }
    elseif (strlen($newPassword) < 8) {
        $_SESSION['failed'] = "Password baru minimal 8 karakter.";
    }
    elseif ($newPassword !== $confirmPassword) {
        $_SESSION['failed'] = "Konfirmasi password tidak sama.";
    }
    else {
        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $db->execute(
            "UPDATE users SET password=? WHERE id=?",
            [$newHash, $userId]
        );
        $_SESSION['success'] = "Password berhasil diperbarui.";
    }
    header("Location: setting.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Setting | Aplikasi Pembelian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <style>
        nav.navbar {
            background-color: #1B4F72 !important;
        }

        #sidebar {
            background-color: #2874A6;
            transition: width 0.3s;
        }

        #sidebar .nav-link {
            transition: background 0.3s, color 0.3s;
        }
        #sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
            color: #FFF;
        }

        #content {
            background-color: #EBF5FB;
        }

        #PembelianTable thead {
            background-color: #3498DB;
            color: #FFFFFF;
            font-weight: bold;
        }

        #PembelianTable tbody tr:hover {
            background-color: #D6EAF8;
        }

        #sidebar.collapsed {
            width: 60px !important;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

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
<?php unset($_SESSION['success']); endif; ?>

<?php if(isset($_SESSION['failed'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '<?= $_SESSION['failed']; ?>',
        timer: 2000,
        showConfirmButton: false
    });
</script>
<?php unset($_SESSION['failed']); endif; ?>

<?php include 'layouts/header.php'; ?>
<div class="d-flex flex-grow-1 mt-5 position-relative">
    <?php include 'layouts/sidebar.php'; ?>
    <?php include 'contents/setting.php'; ?>
</div>
<?php include 'layouts/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new DataTable('#PembelianTable', {
        paging: true,
        searching: true,
        ordering: true,
        info: true
    });

    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const texts = document.querySelectorAll('.sidebar-text');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        texts.forEach(text => {
            text.classList.toggle('d-none');
        });
    });
});
</script>
</body>
</html>
