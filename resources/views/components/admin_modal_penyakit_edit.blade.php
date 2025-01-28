<!-- Modal Edit Penyakit -->
<div class="modal fade modal-fullscreen-md-down" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Penyakit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-penyakit" action="{{ route('penyakit.update', ':id') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="input-form d-flex flex-column w-100">
                        <input type="hidden" name="id" id="id_penyakit">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="kode-penyakit" name="kode_penyakit" required>
                            <label for="kode-penyakit">Kode Penyakit</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="penyakit" name="penyakit" required>
                            <label for="penyakit">Penyakit</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="penangan" name="penangan" rows="4" required></textarea>
                            <label for="penangan">Penanganan</label>
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
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="penangan" name="penangan" rows="4" required></textarea>
                    <label for="penangan">Penanganan</label>
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
    function updateInput(url, idPenyakit) {
    const apiUrl = url.replace(':id', idPenyakit);

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            document.getElementById("kode-penyakit").value = data.kode_penyakit;
            document.getElementById("penyakit").value = data.penyakit;
            document.getElementById("penangan").value = data.penangan;
            document.getElementById("id_penyakit").value = data.id;

            // Ganti action form untuk endpoint PUT
            document.getElementById("edit-penyakit").action = apiUrl;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

</script>


