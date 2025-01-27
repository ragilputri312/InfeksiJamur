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
                    <input type="text" class="form-control" id="kode-gejala" placeholder="Kode Gejala" name="kode_gejala">
                    <label for="kode-gejala">Kode Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="gejala" placeholder="Gejala" name="gejala">
                    <label for="gejala">Gejala</label>
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
                    <input type="text" class="form-control" id="kode-gejala" name="kode_gejala" required>
                    <label for="kode-gejala">Kode Gejala</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="gejala" name="gejala" required>
                    <label for="gejala">Gejala</label>
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
<!-- End Modal Tambah Gejala -->


<script>
    function updateInput(url, idGejala, kode, gejala){
        const formGejala = document.getElementById('edit-gejala');
        formGejala.setAttribute('action', url.replace(':id', idGejala)); // Ganti placeholder :id dengan ID sebenarnya
        formGejala.setAttribute('method', 'POST');
        document.getElementById("kode-gejala").value = kode;
        document.getElementById("gejala").value = gejala;
        document.getElementById("id_gejala").value = idGejala;
    }

</script>

