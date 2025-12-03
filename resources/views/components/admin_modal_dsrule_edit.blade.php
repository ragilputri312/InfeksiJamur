<!-- Modal Tambah Relasi Gejala-Penyakit -->
<div class="modal fade" id="dsRuleCreateModal" tabindex="-1" aria-labelledby="dsRuleCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dsRuleCreateLabel">Tambah Relasi Gejala-Penyakit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ds-rule-create-form" action="{{ route('ds-rules.store') }}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <select class="form-select @error('penyakit_id') is-invalid @enderror" id="penyakit_id_create" name="penyakit_id" required>
                            <option value="">Pilih Penyakit</option>
                            @foreach($penyakit ?? [] as $p)
                                <option value="{{ $p->id }}" >{{ $p->kode_penyakit }} - {{ $p->penyakit }}</option>
                            @endforeach
                        </select>
                        <label for="penyakit_id_create">Penyakit</label>
                        @error('penyakit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select @error('gejala_id') is-invalid @enderror" id="gejala_id_create" name="gejala_id" required>
                            <option value="">Pilih Gejala</option>
                            @foreach($gejala ?? [] as $g)
                                <option value="{{ $g->id }}" >{{ $g->kode_gejala }} - {{ $g->gejala }}</option>
                            @endforeach
                        </select>
                        <label for="gejala_id_create">Gejala</label>
                        @error('gejala_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select @error('keunikan') is-invalid @enderror" id="keunikan_create" name="keunikan" required>
                            <option value="">Pilih Keunikan</option>
                            @foreach($keunikanOptions ?? [] as $option)
                                <option value="{{ $option->label }}">{{ $option->label }} ({{ $option->nilai }})</option>
                            @endforeach
                        </select>
                        <label for="keunikan_create">Keunikan</label>
                        <div class="form-text">Tingkat keunikan gejala terhadap penyakit ini (dari Master Parameter Fuzzy)</div>
                        @error('keunikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi_create" name="deskripsi" style="height: 80px"></textarea>
                        <label for="deskripsi_create">Deskripsi Relasi</label>
                        <div class="form-text">Penjelasan singkat tentang hubungan gejala dengan penyakit (opsional)</div>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active_create" name="is_active" checked>
                        <label class="form-check-label" for="is_active_create">
                            Relasi Aktif
                        </label>
                        <div class="form-text">Centang untuk mengaktifkan relasi ini dalam sistem diagnosis</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="ds-rule-create-form">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Relasi Gejala-Penyakit -->
<div class="modal fade" id="dsRuleEditModal" tabindex="-1" aria-labelledby="dsRuleEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="dsRuleEditLabel">Edit Relasi Gejala-Penyakit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ds-rule-edit-form" action="" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" id="id_dsrule_edit">
                    <div class="form-floating mb-3">
                        <select class="form-select @error('penyakit_id') is-invalid @enderror" id="penyakit_id_edit" name="penyakit_id" required>
                            <option value="">Pilih Penyakit</option>
                            @foreach($penyakit ?? [] as $p)
                                <option value="{{ $p->id }}" >{{ $p->kode_penyakit }} - {{ $p->penyakit }}</option>
                            @endforeach
                        </select>
                        <label for="penyakit_id_edit">Penyakit</label>
                        @error('penyakit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select @error('gejala_id') is-invalid @enderror" id="gejala_id_edit" name="gejala_id" required>
                            <option value="">Pilih Gejala</option>
                            @foreach($gejala ?? [] as $g)
                                <option value="{{ $g->id }}" >{{ $g->kode_gejala }} - {{ $g->gejala }}</option>
                            @endforeach
                        </select>
                        <label for="gejala_id_edit">Gejala</label>
                        @error('gejala_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select @error('keunikan') is-invalid @enderror" id="keunikan_edit" name="keunikan" required>
                            <option value="">Pilih Keunikan</option>
                            @foreach($keunikanOptions ?? [] as $option)
                                <option value="{{ $option->label }}">{{ $option->label }} ({{ $option->nilai }})</option>
                            @endforeach
                        </select>
                        <label for="keunikan_edit">Keunikan</label>
                        <div class="form-text">Tingkat keunikan gejala terhadap penyakit ini (dari Master Parameter Fuzzy)</div>
                        @error('keunikan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi_edit" name="deskripsi" style="height: 80px"></textarea>
                        <label for="deskripsi_edit">Deskripsi Relasi</label>
                        <div class="form-text">Penjelasan singkat tentang hubungan gejala dengan penyakit (opsional)</div>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active_edit" name="is_active" >
                        <label class="form-check-label" for="is_active_edit">
                            Relasi Aktif
                        </label>
                        <div class="form-text">Centang untuk mengaktifkan relasi ini dalam sistem diagnosis</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="ds-rule-edit-form">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if there are validation errors and reopen modal
    @if($errors->any())
        @if($errors->has('penyakit_id') || $errors->has('gejala_id') || $errors->has('keunikan') || $errors->has('deskripsi'))
            // Use localStorage to determine which modal to open
            setTimeout(function() {
                const lastModal = localStorage.getItem('dsRuleLastModal') || 'create';
                let modalToOpen = null;

                if (lastModal === 'create') {
                    modalToOpen = 'dsRuleCreateModal';
                } else if (lastModal === 'edit') {
                    modalToOpen = 'dsRuleEditModal';
                } else {
                    // Default to create modal
                    modalToOpen = 'dsRuleCreateModal';
                }

                const modalEl = document.getElementById(modalToOpen);
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();

                    // If it's edit modal, populate the form with original data
                    if (modalToOpen === 'dsRuleEditModal') {
                        // Get the ID from localStorage or from the form action
                        const editId = localStorage.getItem('dsRuleEditId');
                        if (editId) {
                            const showUrl = `/ds-rules/${editId}`;

                            fetch(showUrl)
                                .then(response => response.json())
                                .then(data => {
                                    const penyakitSelect = document.getElementById('penyakit_id_edit');
                                    const gejalaSelect = document.getElementById('gejala_id_edit');
                                    const keunikanSelect = document.getElementById('keunikan_edit');
                                    const deskripsiInput = document.getElementById('deskripsi_edit');
                                    const isActiveCheckbox = document.getElementById('is_active_edit');
                                    const idInput = document.getElementById('id_dsrule_edit');
                                    const editForm = document.getElementById('ds-rule-edit-form');

                                    // Set form action
                                    const updateUrl = `/ds-rules/${editId}`;
                                    if (editForm) {
                                        editForm.setAttribute('action', updateUrl);
                                        console.log('Auto-opened form action set to:', updateUrl);
                                    }

                                    // Populate form fields
                                    if (penyakitSelect) penyakitSelect.value = data.penyakit_id || '';
                                    if (gejalaSelect) gejalaSelect.value = data.gejala_id || '';
                                    if (keunikanSelect) keunikanSelect.value = data.keunikan || '';
                                    if (deskripsiInput) deskripsiInput.value = data.deskripsi || '';
                                    if (isActiveCheckbox) isActiveCheckbox.checked = data.is_active || false;
                                    if (idInput) idInput.value = data.id || '';
                                })
                                .catch(error => {
                                    console.error('Error fetching DS rule data for auto-populate:', error);
                                });
                        }
                    }
                }
            }, 500);
        @endif
    @endif

    // Store modal type in localStorage when modals are opened
    const createModalEl = document.getElementById('dsRuleCreateModal');
    if (createModalEl) {
        createModalEl.addEventListener('show.bs.modal', function() {
            localStorage.setItem('dsRuleLastModal', 'create');
        });
    }

    const editModalEl = document.getElementById('dsRuleEditModal');
    if (editModalEl) {
        editModalEl.addEventListener('show.bs.modal', function() {
            localStorage.setItem('dsRuleLastModal', 'edit');
        });
    }

    // Form validation for create form
    const createForm = document.getElementById('ds-rule-create-form');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            const penyakit = document.getElementById('penyakit_id_create').value;
            const gejala = document.getElementById('gejala_id_create').value;
            const keunikan = document.getElementById('keunikan_create').value;

            if (!penyakit || !gejala || !keunikan) {
                e.preventDefault();
                alert('Pilih penyakit, gejala, dan keunikan terlebih dahulu!');
                return false;
            }
        });
    }

    // Form validation for edit form
    const editForm = document.getElementById('ds-rule-edit-form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const penyakit = document.getElementById('penyakit_id_edit').value;
            const gejala = document.getElementById('gejala_id_edit').value;
            const keunikan = document.getElementById('keunikan_edit').value;

            if (!penyakit || !gejala || !keunikan) {
                e.preventDefault();
                alert('Pilih penyakit, gejala, dan keunikan terlebih dahulu!');
                return false;
            }
        });
    }
});
</script>

