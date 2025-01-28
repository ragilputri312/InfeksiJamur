<!-- Modal Edit Gejala -->
<div class="modal fade modal-fullscreen-md-down" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Nilai Certainty Factor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="edit-nilaicf" action="" method="post">
            @method('PUT')
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <input type="hidden" name="id" id="id">
                <div class="form-floating mb-3">
                    <select class="form-select" id="kode-gejala-edit" name="kode_gejala" required>
                        <option value="" disabled>Pilih Gejala</option>
                        @foreach ($gejala as $g)
                            <option value="{{ $g->kode_gejala }}" id="gejala-{{ $g->kode_gejala }}">{{ $g->kode_gejala }} - {{ $g->gejala }}</option>
                        @endforeach
                    </select>
                    <label for="kode-gejala-edit">Kode Gejala</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="kode-penyakit-edit" name="kode_penyakit" required>
                        <option value="" disabled>Pilih Penyakit</option>
                        @foreach ($penyakit as $p)
                            <option value="{{ $p->kode_penyakit }}" id="penyakit-{{ $p->kode_penyakit }}">{{ $p->kode_penyakit }} - {{ $p->penyakit }}</option>
                        @endforeach
                    </select>
                    <label for="kode-penyakit-edit">Kode Penyakit</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mb" placeholder="mb" name="mb">
                    <label for="mb">MB</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="md" placeholder="md" name="md">
                    <label for="md">MD</label>
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Nilai Certainty Factor</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- form --}}
          <form id="tambah-nilaicf" action="{{ route('nilaicf.store') }}" method="post">
            @csrf
            <div class="input-form d-flex flex-column w-100">
                <div class="form-floating mb-3">
                    <select class="form-select" id="kode-gejala" name="kode_gejala" required>
                        <option value="" selected disabled>Pilih Gejala</option>
                        @foreach ($gejala as $g)
                            <option value="{{ $g->kode_gejala }}">{{ $g->kode_gejala }} - {{ $g->gejala }}</option>
                        @endforeach
                    </select>
                    <label for="kode-gejala">Kode Gejala</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="kode-penyakit" name="kode_penyakit" required>
                        <option value="" selected disabled>Pilih Penyakit</option>
                        @foreach ($penyakit as $p)
                            <option value="{{ $p->kode_penyakit }}">{{ $p->kode_penyakit }} - {{ $p->penyakit }}</option>
                        @endforeach
                    </select>
                    <label for="kode-penyakit">Kode Penyakit</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="mb" name="mb" required>
                    <label for="mb">MB</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="md" name="md" required>
                    <label for="md">MD</label>
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
function updateInput(url, id, kode_gejala, kode_penyakit, mb, md) {
    const formNilaiCF = document.getElementById('edit-nilaicf');
    formNilaiCF.setAttribute('action', url.replace(':id', id));
    document.getElementById("kode-gejala-edit").value = kode_gejala;
    document.getElementById("kode-penyakit-edit").value = kode_penyakit;
    document.getElementById("mb").value = mb;
    document.getElementById("md").value = md;
}


</script>

