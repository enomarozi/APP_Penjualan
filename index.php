<?php
session_start();
if($_SESSION['login'] !== 1 && empty($_SESSION['username'])){
    $_SESSION = [];
    header("location: logout.php");
}
require_once 'koneksi.php';
$db = new Database();

if(isset($_POST['submit']) && $_POST['submit'] === "simpan"){

    $tanggal         = $_POST['tanggal'];
    $layanan_produk  = $_POST['layanan_produk'];
    $jenis           = $_POST['jenis'];
    $jumlah          = $_POST['jumlah'];
    $harga           = $_POST['harga'];
    $total           = $_POST['total'];
    $toko            = $_POST['toko'];
    $deskripsi       = $_POST['deskripsi'];

    $foto = null;

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $fileTmp   = $_FILES['foto']['tmp_name'];
        $fileName  = basename($_FILES['foto']['name']);
        $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','gif'];

        if(in_array($fileExt, $allowed)){
            $newFileName = uniqid('foto_', true) . '.' . $fileExt;
            $uploadDir   = 'uploads/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($fileTmp, $uploadDir . $newFileName);
            $foto = $newFileName;
        } else {
            $_SESSION['failed'] = "Format foto tidak diperbolehkan. Gunakan JPG, PNG, GIF.";
            header("Location: index.php");
            exit();
        }
    }

    $db->execute(
        "INSERT INTO pembelian (tanggal, layanan_produk, jenis, jumlah, harga, total, toko, deskripsi, foto) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
        [$tanggal, $layanan_produk, $jenis, $jumlah, $harga, $total, $toko, $deskripsi, $foto]
    );

    $_SESSION['success'] = "Data Pembelian berhasil disimpan.";
    header("Location: index.php");
    exit();
}

elseif(isset($_POST['submit']) && $_POST['submit'] === "update"){

    $id              = $_POST['id'];
    $tanggal         = $_POST['tanggal'];
    $layanan_produk  = $_POST['layanan_produk'];
    $jenis           = $_POST['jenis'];
    $jumlah          = $_POST['jumlah'];
    $harga           = $_POST['harga'];
    $total           = $_POST['total'];
    $toko            = $_POST['toko'];
    $deskripsi       = $_POST['deskripsi'];

    $foto = null;

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
        $fileTmp   = $_FILES['foto']['tmp_name'];
        $fileName  = basename($_FILES['foto']['name']);
        $fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','gif'];

        if(in_array($fileExt, $allowed)){
            $newFileName = uniqid('foto_', true) . '.' . $fileExt;
            $uploadDir   = 'uploads/';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($fileTmp, $uploadDir . $newFileName);
            $foto = $newFileName;

            // Optional: hapus foto lama
            $oldFoto = $db->query("SELECT foto FROM pembelian WHERE id=? LIMIT 1", [$id]);
            if($oldFoto && !empty($oldFoto[0]['foto']) && file_exists($uploadDir.$oldFoto[0]['foto'])){
                unlink($uploadDir.$oldFoto[0]['foto']);
            }
        } else {
            $_SESSION['failed'] = "Format foto tidak diperbolehkan. Gunakan JPG, PNG, GIF.";
            header("Location: index.php");
            exit();
        }
    }

    if($foto){
        $db->execute(
            "UPDATE pembelian SET tanggal=?, layanan_produk=?, jenis=?, jumlah=?, harga=?, total=?, toko=?, deskripsi=?, foto=? WHERE id=?",
            [$tanggal, $layanan_produk, $jenis, $jumlah, $harga, $total, $toko, $deskripsi, $foto, $id]
        );
    } else {
        $db->execute(
            "UPDATE pembelian SET tanggal=?, layanan_produk=?, jenis=?, jumlah=?, harga=?, total=?, toko=?, deskripsi=? WHERE id=?",
            [$tanggal, $layanan_produk, $jenis, $jumlah, $harga, $total, $toko, $deskripsi, $id]
        );
    }
    $_SESSION['success'] = "Data Pembelian berhasil diperbarui.";
    header("Location: index.php");
    exit();
}
elseif(isset($_POST['submit']) && $_POST['submit'] === "hapus"){
    $id = $_POST['id'];
    $fotoData = $db->query("SELECT foto FROM pembelian WHERE id=? LIMIT 1", [$id]);
    if($fotoData && !empty($fotoData[0]['foto'])){
        $filePath = 'uploads/' . $fotoData[0]['foto'];
        if(file_exists($filePath)){
            unlink($filePath);
        }
    }
    $db->execute("DELETE FROM pembelian WHERE id=?", [$id]);
    $_SESSION['success'] = "Data pembelian berhasil dihapus.";
    header("Location: index.php");
    exit();
}

$dataPembelian = $db->query("SELECT * FROM pembelian ORDER BY tanggal DESC");
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
        timer: 1500,
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
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Layanan / Produk</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Toko</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            foreach($dataPembelian as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><img src="uploads/<?= $row['foto']; ?>" alt="Foto" style="width: 120px; height: 120px; object-fit: cover;"></td>
                                <td><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['layanan_produk']; ?></td>
                                <td><?= $row['jenis']; ?></td>
                                <td><?= $row['jumlah']; ?></td>
                                <td><?= "Rp ".number_format($row['harga'],0,',','.'); ?></td>
                                <td><?= "Rp ".number_format($row['total'],0,',','.'); ?></td>
                                <td><?= $row['toko']; ?></td>
                                <td><?= $row['deskripsi']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" 
                                        data-id="<?= $row['id']; ?>" 
                                        data-tanggal="<?= date('Y-m-d', strtotime($row['tanggal'])); ?>"
                                        data-layanan_produk="<?= $row['layanan_produk']; ?>"
                                        data-jenis="<?= $row['jenis']; ?>"
                                        data-jumlah="<?= $row['jumlah']; ?>"
                                        data-harga="<?= $row['harga']; ?>"
                                        data-total="<?= $row['total']; ?>"
                                        data-toko="<?= $row['toko']; ?>"
                                        data-deskripsi="<?= $row['deskripsi']; ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit">Edit</button>
                                    <button class="btn btn-info btn-sm details-btn" 
                                        data-id="<?= $row['id']; ?>" 
                                        data-tanggal="<?= date('Y-m-d', strtotime($row['tanggal'])); ?>"
                                        data-layanan_produk="<?= $row['layanan_produk']; ?>"
                                        data-jenis="<?= $row['jenis']; ?>"
                                        data-jumlah="<?= $row['jumlah']; ?>"
                                        data-harga="<?= $row['harga']; ?>"
                                        data-total="<?= $row['total']; ?>"
                                        data-toko="<?= $row['toko']; ?>"
                                        data-deskripsi="<?= $row['deskripsi']; ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetails">Detail</button>
                                    <button class="btn btn-danger btn-sm hapus-btn" 
                                        data-id="<?= $row['id']; ?>"
                                        data-tanggal="<?= date('Y-m-d', strtotime($row['tanggal'])); ?>"
                                        data-layanan_produk="<?= $row['layanan_produk']; ?>"
                                        data-jenis="<?= $row['jenis']; ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalHapus">Hapus</button>
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

document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        const tanggal = this.dataset.tanggal;
        const layanan = this.dataset.layanan_produk;
        const jenis = this.dataset.jenis;
        const jumlah = this.dataset.jumlah;
        const harga = this.dataset.harga;
        const total = this.dataset.total;
        const toko = this.dataset.toko;
        const deskripsi = this.dataset.deskripsi;
        const fotoSrc = this.closest('tr').querySelector('td img').src;

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_tanggal').value = tanggal;
        document.getElementById('edit_layanan_produk').value = layanan;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_jumlah').value = jumlah;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_total').value = total;
        document.getElementById('edit_toko').value = toko;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('previewEditFoto').src = fotoSrc;
        document.getElementById('previewEditFoto').style.display = 'block';
    });
});

document.querySelectorAll('.details-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        const tanggal = this.dataset.tanggal;
        const layanan = this.dataset.layanan_produk;
        const jenis = this.dataset.jenis;
        const jumlah = this.dataset.jumlah;
        const harga = this.dataset.harga;
        const total = this.dataset.total;
        const toko = this.dataset.toko;
        const deskripsi = this.dataset.deskripsi;
        const fotoSrc = this.closest('tr').querySelector('td img').src;

        document.getElementById('details_id').value = id;
        document.getElementById('details_tanggal').value = tanggal;
        document.getElementById('details_layanan_produk').value = layanan;
        document.getElementById('details_jenis').value = jenis;
        document.getElementById('details_jumlah').value = jumlah;
        document.getElementById('details_harga').value = harga;
        document.getElementById('details_total').value = total;
        document.getElementById('details_toko').value = toko;
        document.getElementById('details_deskripsi').value = deskripsi;
        document.getElementById('details_foto').src = fotoSrc;
    });
});


document.querySelectorAll('.hapus-btn').forEach(btn =>{
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        const tanggal = this.dataset.tanggal;
        const layanan = this.dataset.layanan_produk;
        const jenis = this.dataset.jenis;

        document.getElementById('hapus_id').value = id;
        document.getElementById('hapus_jenis').value = jenis;
        document.getElementById('hapus_layanan_produk').value = layanan;
        document.getElementById('pesan').innerHTML = `Apakah anda yakin ingin menghapus data <strong>${jenis} ${layanan}</strong> pada tanggal <strong>${tanggal}</strong>`;
    })
})
</script>
<?php include 'modals/tambah_data.php'; ?>
<?php include 'modals/edit_data.php'; ?>
<?php include 'modals/details_data.php'; ?>
<?php include 'modals/hapus_data.php'; ?>
</body>
</html>
