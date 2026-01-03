<div class="modal fade" id="modalDetails" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-eye"></i> Detail Data Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3 text-center">
          <label class="form-label">Foto</label><br>
          <img id="details_foto" src="" alt="Foto" style="width:120px; height:120px; object-fit:cover;">
        </div>

        <input type="hidden" id="details_id">

        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" class="form-control" id="details_tanggal" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Layanan / Produk</label>
          <input type="text" class="form-control" id="details_layanan_produk" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis</label>
          <input type="text" class="form-control" id="details_jenis" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Jumlah</label>
          <input type="number" class="form-control" id="details_jumlah" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" class="form-control" id="details_harga" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Total</label>
          <input type="number" class="form-control" id="details_total" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Toko / Lokasi</label>
          <input type="text" class="form-control" id="details_toko" readonly>
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control" rows="3" id="details_deskripsi" readonly></textarea>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>
