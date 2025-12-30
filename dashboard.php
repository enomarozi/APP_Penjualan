<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Aplikasi Pembelian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid d-flex" style="padding: 0;">
    	<img src="assets/images/spiderman.jpg" width="220" height="50" style="margin-right:10px; border-right:2px solid #ffffff; padding-right:10px;">
        <button class="btn btn-light btn-sm" id="toggleSidebar">☰</button>
        <div class="flex-grow-1"></div>
        <span class="navbar-brand mb-0 h1">Logout</span>
    </div>
</nav>

<div class="d-flex flex-grow-1 mt-5 position-relative">
    <aside id="sidebar" class="text-white p-3 position-sticky" style="top: 56px; width: 220px; height: calc(100vh - 56px - 40px); z-index: 10;">
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a class="nav-link text-white" href="#">📊 Dashboard</a></li>
            <li class="nav-item mb-2"><a class="nav-link text-white" href="#">🛒 Pembelian</a></li>
            <li class="nav-item mb-2"><a class="nav-link text-white" href="#">📦 Produk</a></li>
            <li class="nav-item mb-2"><a class="nav-link text-white" href="#">📑 Laporan</a></li>
            <li class="nav-item mt-4"><a class="nav-link text-white" href="#">🚪 Logout</a></li>
        </ul>
    </aside>

    <section id="content" class="flex-grow-1 p-4">
        <h4 class="mb-4">Data Pembelian</h4>
        <div class="card">
            <div class="card-body">
                <table id="PembelianTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2025-12-30</td>
                            <td>Produk A</td>
                            <td>5</td>
                            <td>50000</td>
                            <td>250000</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2025-12-30</td>
                            <td>Produk B</td>
                            <td>3</td>
                            <td>30000</td>
                            <td>90000</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2025-12-29</td>
                            <td>Produk C</td>
                            <td>2</td>
                            <td>75000</td>
                            <td>150000</td>
                        </tr>
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

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
});
</script>

</body>
</html>
