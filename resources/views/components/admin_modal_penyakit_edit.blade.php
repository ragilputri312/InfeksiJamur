<!-- Legacy modals removed to avoid duplicate IDs -->

<div class="modal fade" id="penyakitEditModal" tabindex="-1" aria-labelledby="penyakitEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="penyakitEditLabel">Ubah Penyakit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="penyakit-edit-form" action="" method="post">
          @method('PUT')
          @csrf
          <input type="hidden" name="id" id="id_penyakit">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="kode-penyakit" placeholder="Kode Penyakit" name="kode_penyakit" required>
            <label for="kode-penyakit">Kode Penyakit</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="penyakit-nama" placeholder="Nama Penyakit" name="penyakit" required>
            <label for="penyakit-nama">Nama Penyakit</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Penanganan" id="penangan" name="penangan" style="height: 120px" required></textarea>
            <label for="penangan">Penanganan</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="penyakit-edit-form">Ubah</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="penyakitCreateModal" tabindex="-1" aria-labelledby="penyakitCreateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="penyakitCreateLabel">Tambah Penyakit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="penyakit-create-form" action="{{ route('penyakit.store') }}" method="post">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="kode-penyakit-create" name="kode_penyakit" required>
            <label for="kode-penyakit-create">Kode Penyakit</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="penyakit-nama-create" name="penyakit" required>
            <label for="penyakit-nama-create">Nama Penyakit</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" id="penangan-create" name="penangan" style="height: 120px" required></textarea>
            <label for="penangan-create">Penanganan</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="penyakit-create-form">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Old helper script removed -->


