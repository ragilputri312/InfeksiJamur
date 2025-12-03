<!-- Modal Store Keunikan -->
<div class="modal fade" id="storeModalKeunikan" tabindex="-1" aria-labelledby="storeModalKeunikanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('fuzzy-parameters.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipe" value="keunikan">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="storeModalKeunikanLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Parameter Keunikan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="label_keunikan" class="form-label">Label <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="label_keunikan" name="label" required
                            placeholder="Contoh: Rendah, Sedang, Tinggi">
                        <small class="text-muted">Nama label untuk parameter keunikan</small>
                    </div>

                    <div class="mb-3">
                        <label for="nilai_keunikan" class="form-label">Nilai (0.00 - 1.00) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="nilai_keunikan" name="nilai"
                            step="0.01" min="0" max="1" required placeholder="0.50">
                        <small class="text-muted">Nilai numerik antara 0.00 hingga 1.00</small>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_keunikan" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_keunikan" name="deskripsi" rows="2"
                            placeholder="Deskripsi parameter (opsional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="urutan_keunikan" class="form-label">Urutan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="urutan_keunikan" name="urutan"
                            min="0" required value="0">
                        <small class="text-muted">Urutan tampilan parameter</small>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active_keunikan" name="is_active" checked>
                        <label class="form-check-label" for="is_active_keunikan">
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

