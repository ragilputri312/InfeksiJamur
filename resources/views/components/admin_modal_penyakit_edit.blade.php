<!-- Modal Edit Penyakit -->
<div class="modal fade modal-fullscreen-md-down" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Penyakit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="edit-penyakit" action="" method="post">
            @method('PUT')
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <input type="hidden" name="id" id="id_penyakit">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="kode-penyakit" placeholder="Kode Penyakit" name="kode_penyakit">
                    <label for="kode-penyakit">Kode Penyakit</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="penyakit" placeholder="Penyakit" name="penyakit">
                    <label for="penyakit">Penyakit</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ubah</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Edit Penyakit -->

<!-- Modal Tambah Penyakit -->
<div class="modal fade modal-fullscreen-md-down" id="storeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Penyakit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="tambah-penyakit" action="{{ route('penyakit.store') }}" method="post">
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="kode-penyakit" name="kode_penyakit" required>
                    <label for="kode-penyakit">Kode Penyakit</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="penyakit" name="penyakit" required>
                    <label for="penyakit">Penyakit</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal Tambah Penyakit -->


<script>
    function updateInput(url, idPenyakit, kode, penyakit){
        const formPenyakit = document.getElementById('edit-penyakit');
        formPenyakit.setAttribute('action', url.replace(':id', idPenyakit));
        formPenyakit.setAttribute('method', 'POST');
        document.getElementById("kode-penyakit").value = kode;
        document.getElementById("penyakit").value = penyakit;
        document.getElementById("id_penyakit").value = idPenyakit;
    }

</script>

