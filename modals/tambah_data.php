<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Data Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formTambah" method="POST" enctype="multipart/form-data">
        <div class="modal-body">

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Layanan / Produk</label>
                <input type="text" name="layanan_produk" class="form-control" placeholder="Ganti Oli / Ban / Sparepart" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select" required>
                    <option value="" selected disabled>Pilih jenis</option>
                    <option value="Service">Service</option>
                    <option value="Sparepart">Sparepart</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" name="total" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Toko / Lokasi</label>
                <input type="text" name="toko" class="form-control" placeholder="Nama Toko / Lokasi" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tambahkan catatan / keterangan" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm" name="submit" value="simpan">Simpan</button>
        </div>
    </form>

    </div>
  </div>
</div>
