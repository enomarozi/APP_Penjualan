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