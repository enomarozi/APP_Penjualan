<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Data Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="formEdit" method="POST">
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" id="edit_tanggal" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Layanan / Produk</label>
            <input type="text" name="layanan_produk" class="form-control" id="edit_layanan_produk" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-select" id="edit_jenis" required>
              <option value="" selected disabled>Pilih jenis</option>
              <option value="Service">Service</option>
              <option value="Sparepart">Sparepart</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="edit_jumlah" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" id="edit_harga" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" id="edit_total" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm" name="submit" value="update">Simpan Perubahan</button>
        </div>
      </form>

    </div>
  </div>
</div>
