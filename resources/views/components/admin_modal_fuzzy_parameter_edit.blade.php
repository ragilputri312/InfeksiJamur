<!-- Modal Edit Parameter Fuzzy -->
<div class="modal fade modal-fullscreen-md-down" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Ubah Parameter Fuzzy</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="edit-parameter" action="" method="post">
            @method('PUT')
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <input type="hidden" name="id" id="id_parameter">
                <div class="form-floating mb-3">
                    <select class="form-select" id="tipe-edit" name="tipe" required>
                        <option value="">Pilih Tipe</option>
                        <option value="kemunculan">Kemunculan</option>
                        <option value="keunikan">Keunikan</option>
                    </select>
                    <label for="tipe-edit">Tipe Parameter</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="label-edit" placeholder="Label Parameter" name="label" required>
                    <label for="label-edit">Label Parameter</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="nilai-edit" placeholder="Nilai (0-1)" name="nilai" min="0" max="1" step="0.01" required>
                    <label for="nilai-edit">Nilai (0-1)</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="deskripsi-edit" placeholder="Deskripsi" name="deskripsi" style="height: 100px"></textarea>
                    <label for="deskripsi-edit">Deskripsi</label>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active-edit" name="is_active" value="1">
                            <label class="form-check-label" for="is_active-edit">Aktif</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="urutan-edit" name="urutan" min="0" placeholder="Urutan">
                            <label for="urutan-edit">Urutan</label>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="edit-parameter">Ubah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Edit Parameter Fuzzy -->

<script>
    function updateParameterInput(url, idParameter, tipe, label, nilai, deskripsi = '', isActive = 1, urutan = ''){
        const formParameter = document.getElementById('edit-parameter');
        formParameter.setAttribute('action', url.replace(':id', idParameter));
        formParameter.setAttribute('method', 'POST');
        document.getElementById("tipe-edit").value = tipe;
        document.getElementById("label-edit").value = label;
        document.getElementById("nilai-edit").value = nilai;
        document.getElementById("deskripsi-edit").value = deskripsi || '';
        document.getElementById("is_active-edit").checked = !!isActive;
        document.getElementById("urutan-edit").value = (urutan ?? '');
        document.getElementById("id_parameter").value = idParameter;
    }
</script>
