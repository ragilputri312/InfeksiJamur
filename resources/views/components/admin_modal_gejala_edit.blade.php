<!-- Modal Edit Gejala -->
<div class="modal fade modal-fullscreen-md-down" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Gejala</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="edit-gejala" action="" method="post">
            @method('PUT')
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <input type="hidden" name="id" id="id_gejala">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="kode-gejala" placeholder="Kode Gejala" name="kode_gejala" required>
                    <label for="kode-gejala">Kode Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="gejala" placeholder="Gejala" name="gejala" required>
                    <label for="gejala">Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="pertanyaan" placeholder="Pertanyaan Ya/Tidak" name="pertanyaan">
                    <label for="pertanyaan">Pertanyaan (Ya/Tidak)</label>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1">
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="urutan" name="urutan" min="0" placeholder="Urutan">
                            <label for="urutan">Urutan</label>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" form="edit-gejala">Ubah</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Edit Gejala -->

<!-- Modal Tambah Gejala -->
<div class="modal fade modal-fullscreen-md-down" id="storeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Gejala</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="tambah-gejala" action="{{ route('gejala.store') }}" method="post">
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="kode-gejala-create" name="kode_gejala" required>
                    <label for="kode-gejala-create">Kode Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="gejala-create" name="gejala" required>
                    <label for="gejala-create">Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="pertanyaan-create" name="pertanyaan" placeholder="Pertanyaan Ya/Tidak">
                    <label for="pertanyaan-create">Pertanyaan (Ya/Tidak)</label>
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
          <button type="submit" class="btn btn-primary" form="tambah-gejala">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Tambah Gejala -->


<script>
    function updateInput(url, idGejala, kode, gejala, pertanyaan = '', isActive = 1, urutan = ''){
        const formGejala = document.getElementById('edit-gejala');
        formGejala.setAttribute('action', url.replace(':id', idGejala)); // Ganti placeholder :id dengan ID sebenarnya
        formGejala.setAttribute('method', 'POST');
        document.getElementById("kode-gejala").value = kode;
        document.getElementById("gejala").value = gejala;
        document.getElementById("pertanyaan").value = pertanyaan || '';
        document.getElementById("is_active").checked = !!isActive;
        document.getElementById("urutan").value = (urutan ?? '')
        document.getElementById("id_gejala").value = idGejala;
    }
</script>

