<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit Parameter Fuzzy
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_tipe" name="tipe" required disabled>
                            <option value="kemunculan">Kemunculan</option>
                            <option value="keunikan">Keunikan</option>
                        </select>
                        <input type="hidden" id="edit_tipe_hidden" name="tipe">
                        <small class="text-muted">Tipe parameter tidak dapat diubah</small>
                    </div>

                    <div class="mb-3">
                        <label for="edit_label" class="form-label">Label <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_label" name="label" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nilai" class="form-label">Nilai (0.00 - 1.00) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_nilai" name="nilai"
                            step="0.01" min="0" max="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_urutan" class="form-label">Urutan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_urutan" name="urutan" min="0" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Sync disabled select with hidden input
    document.getElementById('edit_tipe').addEventListener('change', function() {
        document.getElementById('edit_tipe_hidden').value = this.value;
    });

    // Also update on modal open
    function updateInput(routePattern, id, tipe, label, nilai, deskripsi, urutan, isActive) {
        const route = routePattern.replace(':id', id);
        document.getElementById('editForm').action = route;
        document.getElementById('edit_tipe').value = tipe;
        document.getElementById('edit_tipe_hidden').value = tipe;
        document.getElementById('edit_label').value = label;
        document.getElementById('edit_nilai').value = nilai;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('edit_urutan').value = urutan;
        document.getElementById('edit_is_active').checked = isActive == 1;
    }
</script>

