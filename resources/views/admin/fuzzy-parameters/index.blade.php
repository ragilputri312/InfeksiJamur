@extends('admin.admin_main')
@section('title', 'Master Fuzzy Parameter')

@section('admin_content')
        <div class="container mt-lg-5 p-lg-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">
            {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Master Parameter Fuzzy</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#storeModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Parameter
                        </button>
                    </div>

            {{-- Kemunculan Section --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Parameter Kemunculan Gejala</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Label</th>
                                    <th width="15%">Nilai</th>
                                    <th width="30%">Deskripsi</th>
                                    <th width="10%">Urutan</th>
                                    <th width="10%">Status</th>
                                    <th width="10%" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kemunculanParams as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->label }}</strong></td>
                                        <td><span class="badge bg-info">{{ number_format($item->nilai, 2) }}</span></td>
                                        <td class="text-muted small">{{ $item->deskripsi ?? '-' }}</td>
                                        <td>{{ $item->urutan }}</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                                                onclick="updateParameterInput('{{ route('fuzzy-parameters.update', ':id') }}', '{{ $item->id }}', '{{ $item->tipe }}', '{{ $item->label }}', '{{ $item->nilai }}', `{{ $item->deskripsi }}`, {{ $item->is_active ? 1 : 0 }}, '{{ $item->urutan }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('fuzzy-parameters.destroy', $item->id) }}" method="post" class="d-inline form-delete" data-nama="{{ $item->label }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->label }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada data parameter kemunculan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Keunikan Section --}}
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Parameter Keunikan Gejala</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Label</th>
                                    <th width="15%">Nilai</th>
                                    <th width="30%">Deskripsi</th>
                                    <th width="10%">Urutan</th>
                                    <th width="10%">Status</th>
                                    <th width="10%" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keunikanParams as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->label }}</strong></td>
                                        <td><span class="badge bg-warning text-dark">{{ number_format($item->nilai, 2) }}</span></td>
                                        <td class="text-muted small">{{ $item->deskripsi ?? '-' }}</td>
                                        <td>{{ $item->urutan }}</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                                                onclick="updateParameterInput('{{ route('fuzzy-parameters.update', ':id') }}', '{{ $item->id }}', '{{ $item->tipe }}', '{{ $item->label }}', '{{ $item->nilai }}', `{{ $item->deskripsi }}`, {{ $item->is_active ? 1 : 0 }}, '{{ $item->urutan }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('fuzzy-parameters.destroy', $item->id) }}" method="post" class="d-inline form-delete" data-nama="{{ $item->label }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->label }}">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada data parameter keunikan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>

{{-- Include Modals --}}
@include('components.admin_modal_fuzzy_parameter_store')
@include('components.admin_modal_fuzzy_parameter_edit')

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah yakin ingin menghapus parameter <strong id="deleteParameterName">-</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateInput(routePattern, id, tipe, label, nilai, deskripsi, urutan, isActive) {
        const route = routePattern.replace(':id', id);
        document.getElementById('editForm').action = route;
        document.getElementById('edit_tipe').value = tipe;
        document.getElementById('edit_label').value = label;
        document.getElementById('edit_nilai').value = nilai;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('edit_urutan').value = urutan;
        document.getElementById('edit_is_active').checked = isActive == 1;
    }

    // Delete confirmation with modal
    (function(){
        function bindDeleteHandlers() {
            let formToSubmit = null;
            const modalEl = document.getElementById('deleteConfirmModal');
            const nameEl = document.getElementById('deleteParameterName');
            const btnConfirm = document.getElementById('btnConfirmDelete');

            // Move modal to <body> to avoid CSS transform/z-index issues
            if (modalEl && modalEl.parentNode !== document.body) {
                document.body.appendChild(modalEl);
            }

            document.querySelectorAll('.btn-delete-trigger').forEach(function(btn){
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    const form = btn.closest('form');
                    const nama = btn.getAttribute('data-nama') || (form ? form.getAttribute('data-nama') : '') || '';
                    formToSubmit = form;
                    nameEl.textContent = nama;
                    if (window.bootstrap && bootstrap.Modal) {
                        const bsModal = new bootstrap.Modal(modalEl);
                        bsModal.show();
                    } else {
                        if (confirm('Apakah yakin ingin menghapus parameter ' + nama + ' ?')) {
                            if (formToSubmit) { formToSubmit.submit(); }
                        }
                    }
                });
            });

            if (btnConfirm) {
                btnConfirm.addEventListener('click', function(){
                    if(formToSubmit){ formToSubmit.submit(); }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindDeleteHandlers);
        } else {
            bindDeleteHandlers();
        }
    })();
</script>
@endsection

