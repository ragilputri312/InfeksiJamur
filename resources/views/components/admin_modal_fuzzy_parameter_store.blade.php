<!-- Modal Tambah Parameter Fuzzy -->
<div class="modal fade modal-fullscreen-md-down" id="storeModal" tabindex="-1" aria-labelledby="storeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="storeModalLabel">Tambah Parameter Fuzzy</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="tambah-parameter" action="{{ route('fuzzy-parameters.store') }}" method="post">
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <div class="form-floating mb-3">
                    <select class="form-select" id="tipe-create" name="tipe" required>
                        <option value="">Pilih Tipe</option>
                        <option value="kemunculan">Kemunculan</option>
                        <option value="keunikan">Keunikan</option>
                    </select>
                    <label for="tipe-create">Tipe Parameter</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="label-create" name="label" required>
                    <label for="label-create">Label Parameter</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="nilai-create" name="nilai" min="0" max="1" step="0.01" required>
                    <label for="nilai-create">Nilai (0-1)</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="deskripsi-create" name="deskripsi" placeholder="Deskripsi" style="height: 100px"></textarea>
                    <label for="deskripsi-create">Deskripsi</label>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active-create" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active-create">Aktif</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="urutan-create" name="urutan" min="0" placeholder="Urutan">
                            <label for="urutan-create">Urutan</label>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="tambah-parameter">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Tambah Parameter Fuzzy -->
