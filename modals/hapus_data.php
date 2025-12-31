<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Pembelian</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formHapus" method="POST">
        <div class="modal-body">
          <input type="hidden" name="id" id="hapus_id">
          <input type="hidden" name="layanan_produk" id="hapus_layanan_produk">
          <input type="hidden" name="jenis" id="hapus_jenis">
          <p id="pesan"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm" name="submit" value="hapus">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
