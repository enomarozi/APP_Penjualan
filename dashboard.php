<?php
session_start();
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
<?php if(isset($_SESSION['success'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= $_SESSION['success']; ?>',
        timer: 1800,
        showConfirmButton: false
    });
</script>
<?php
    unset($_SESSION['success']);
    endif;
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid d-flex" style="padding: 0;">
    	<img src="assets/images/spiderman.jpg" width="220" height="50" style="margin-right:10px; border-right:2px solid #ffffff; padding-right:10px;">
        <button class="btn btn-light btn-sm" id="toggleSidebar">☰</button>
        <div class="flex-grow-1"></div>
        <button type="button" class="btn btn-link text-white text-decoration-none me-3">
            Logout
        </button>
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
    <?php
        require_once 'koneksi.php';
        $db = new Database();

        if(isset($_POST['submit']) && $_POST['submit'] === "simpan"){
            $tanggal = $_POST['tanggal'];
            $layanan_produk = $_POST['layanan_produk'];
            $jenis = $_POST['jenis'];
            $jumlah = $_POST['jumlah'];
            $harga = $_POST['harga'];
            $total = $_POST['total'];
            $db->execute(
                "INSERT INTO pembelian (tanggal, layanan_produk, jenis, jumlah, harga, total) VALUES(?, ?, ?, ?, ?, ?)",
                [$tanggal, $layanan_produk, $jenis, $jumlah, $harga, $total]
            );
            $_SESSION['success'] = "Data Pembelian berhasil disimpan.";
            header("Location: dashboard.php");
            exit();
        }
        $dataPembelian = $db->query("SELECT * FROM pembelian ORDER BY tanggal DESC");
    ?>
    <section id="content" class="flex-grow-1 p-4 mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Data Pembelian</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </button>

        </div>
        <div class="card">
            <div class="card-body">

                <table id="PembelianTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Layanan / Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach($dataPembelian as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['layanan_produk']; ?></td>
                                <td><?= $row['jenis']; ?></td>
                                <td><?= $row['jumlah']; ?></td>
                                <td><?= "Rp ".number_format($row['harga'],0,',','.'); ?></td>
                                <td><?= "Rp ".number_format($row['harga'],0,',','.'); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
                                    <button class="btn btn-danger btn-sm btn-hapus" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalHapus">Hapus</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
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
</body>
</html>
