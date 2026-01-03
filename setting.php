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
    <title>Dashboard | Aplikasi Pembelian</title>

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
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid d-flex" style="padding: 0;">
    	<img src="assets/images/spiderman.jpg" width="220" height="50" style="margin-right:10px; border-right:2px solid #ffffff; padding-right:10px;">
        <button class="btn btn-light btn-sm" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="flex-grow-1"></div>
        <div class="dropdown me-3">
            <a class="btn btn-link text-white text-decoration-none dropdown-toggle d-flex align-items-center p-0" 
               href="#" role="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="font-size: 2rem;"></i>  
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                <li><a class="dropdown-item" href="setting.php">Setting</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>

    </div>
</nav>

<div class="d-flex flex-grow-1 mt-5 position-relative">
    <aside id="sidebar" class="text-white position-sticky" style="top:56px; width:220px;">
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center px-3 py-2" href="#">
                    <i class="bi bi-speedometer2 fs-5"></i>
                    <span class="sidebar-text ms-2">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center px-3 py-2" href="#">
                    <i class="bi bi-cart-check fs-5"></i>
                    <span class="sidebar-text ms-2">Pembelian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center px-3 py-2" href="#">
                    <i class="bi bi-box-seam fs-5"></i>
                    <span class="sidebar-text ms-2">Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center px-3 py-2" href="#">
                    <i class="bi bi-file-earmark-text fs-5"></i>
                    <span class="sidebar-text ms-2">Laporan</span>
                </a>
            </li>
        </ul>
    </aside>
    <section id="content" class="flex-grow-1 p-4 mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Change Password</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="formChangePassword" method="POST">
                    
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Enter old password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>

<footer class="text-center text-muted py-2 mt-auto">
    © 2025 Aplikasi Pembelian
</footer>

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
<?php include 'modals/tambah_data.php'; ?>
<?php include 'modals/edit_data.php'; ?>
<?php include 'modals/details_data.php'; ?>
<?php include 'modals/hapus_data.php'; ?>
</body>
</html>
