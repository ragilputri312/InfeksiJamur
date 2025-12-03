@extends('admin.admin_main')
@section('title', 'Kategori Fuzzy')

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
                    <h5 class="mb-0">Kategori Fuzzy</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fuzzyCategoryCreateModal">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
                    </button>
                </div>

                <div class="table-responsive shadow-sm rounded">
                    <table id="tabel-fuzzy-categories" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Kategori</th>
                                <th>Range Nilai</th>
                                <th>Label</th>
                                <th>Warna</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fuzzyCategories as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $fuzzyCategories->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $item->nama_kategori }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($item->min_value, 2) }}</span>
                                        <span class="text-muted">-</span>
                                        <span class="badge bg-info">{{ number_format($item->max_value, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $item->color }}">{{ $item->label }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $item->color === 'primary' ? '#0d6efd' : ($item->color === 'success' ? '#198754' : ($item->color === 'warning' ? '#ffc107' : ($item->color === 'danger' ? '#dc3545' : '#6c757d'))) }}; border-radius: 3px;"></div>
                                            <span class="text-capitalize">{{ $item->color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-fuzzy-category me-1"
                                            data-bs-toggle="modal" data-bs-target="#fuzzyCategoryEditModal"
                                            data-action="{{ route('fuzzy-categories.update', ':id') }}"
                                            data-id="{{ $item->id }}"
                                            data-nama-kategori="{{ $item->nama_kategori }}"
                                            data-label="{{ $item->label }}"
                                            data-min-value="{{ $item->min_value }}"
                                            data-max-value="{{ $item->max_value }}"
                                            data-color="{{ $item->color }}"
                                            data-is-active="{{ $item->is_active }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('fuzzy-categories.destroy', $item->id) }}" class="d-inline form-delete-fuzzy-category" method="POST" data-nama="{{ $item->nama_kategori }}">
                                            @method('DELETE')
                                            @csrf()
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->nama_kategori }}">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="small text-muted">
                        Menampilkan {{ $fuzzyCategories->firstItem() }}–{{ $fuzzyCategories->lastItem() }} dari {{ $fuzzyCategories->total() }} data
                    </div>
                    <div>
                        @if ($fuzzyCategories->onFirstPage())
                            <span class="btn btn-secondary disabled btn-sm">« Sebelumnya</span>
                        @else
                            <a href="{{ $fuzzyCategories->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">« Sebelumnya</a>
                        @endif

                        @if ($fuzzyCategories->hasMorePages())
                            <a href="{{ $fuzzyCategories->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">Berikutnya »</a>
                        @else
                            <span class="btn btn-secondary disabled btn-sm">Berikutnya »</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin_modal_fuzzy_category_edit')

    <script>
        (function(){
            // Edit Fuzzy Category Modal
            const editModalEl = document.getElementById('fuzzyCategoryEditModal');
            const editForm = document.getElementById('fuzzy-category-edit-form');
            const idInput = document.getElementById('id_fuzzy_category_edit');
            const namaKategoriInput = document.getElementById('nama_kategori_edit');
            const labelInput = document.getElementById('label_edit');
            const minValueInput = document.getElementById('min_value_edit');
            const maxValueInput = document.getElementById('max_value_edit');
            const colorSelect = document.getElementById('color_edit');
            const isActiveCheckbox = document.getElementById('is_active_edit');

            document.querySelectorAll('.btn-edit-fuzzy-category').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const actionUrl = this.dataset.action.replace(':id', id);

                    editForm.setAttribute('action', actionUrl);
                    idInput.value = id;
                    namaKategoriInput.value = this.dataset.namaKategori || '';
                    labelInput.value = this.dataset.label || '';
                    minValueInput.value = this.dataset.minValue || '';
                    maxValueInput.value = this.dataset.maxValue || '';
                    colorSelect.value = this.dataset.color || '';
                    isActiveCheckbox.checked = this.dataset.isActive === '1' || this.dataset.isActive === true;
                });
            });

            // Delete Fuzzy Category Modal
            const deleteModalEl = document.getElementById('deleteFuzzyCategoryModal');
            if (deleteModalEl && deleteModalEl.parentNode !== document.body) {
                document.body.appendChild(deleteModalEl);
            }

            let formToSubmit = null;
            const nameEl = document.getElementById('deleteFuzzyCategoryName');
            const btnConfirm = document.getElementById('btnConfirmDeleteFuzzyCategory');

            document.querySelectorAll('.btn-delete-trigger').forEach(function(btn){
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    const form = btn.closest('form');
                    const nama = btn.getAttribute('data-nama') || (form ? form.getAttribute('data-nama') : '') || '';
                    formToSubmit = form;
                    nameEl.textContent = nama;
                    if (window.bootstrap && bootstrap.Modal) {
                        const bsModal = new bootstrap.Modal(deleteModalEl);
                        bsModal.show();
                    } else {
                        if (confirm('Apakah yakin ingin menghapus kategori ' + nama + ' ?')) {
                            if (formToSubmit) { formToSubmit.submit(); }
                        }
                    }
                });
            });

            if (btnConfirm) {
                btnConfirm.addEventListener('click', function(){
                    if (formToSubmit) { formToSubmit.submit(); }
                });
            }

            // Validasi min_value harus lebih kecil dari max_value untuk create form
            document.getElementById('max_value_create').addEventListener('input', function() {
                const minValue = parseFloat(document.getElementById('min_value_create').value);
                const maxValue = parseFloat(this.value);

                if (minValue >= maxValue) {
                    this.setCustomValidity('Nilai maksimum harus lebih besar dari nilai minimum');
                } else {
                    this.setCustomValidity('');
                }
            });

            document.getElementById('min_value_create').addEventListener('input', function() {
                const minValue = parseFloat(this.value);
                const maxValue = parseFloat(document.getElementById('max_value_create').value);

                if (minValue >= maxValue) {
                    document.getElementById('max_value_create').setCustomValidity('Nilai maksimum harus lebih besar dari nilai minimum');
                } else {
                    document.getElementById('max_value_create').setCustomValidity('');
                }
            });

            // Validasi min_value harus lebih kecil dari max_value untuk edit form
            document.getElementById('max_value_edit').addEventListener('input', function() {
                const minValue = parseFloat(document.getElementById('min_value_edit').value);
                const maxValue = parseFloat(this.value);

                if (minValue >= maxValue) {
                    this.setCustomValidity('Nilai maksimum harus lebih besar dari nilai minimum');
                } else {
                    this.setCustomValidity('');
                }
            });

            document.getElementById('min_value_edit').addEventListener('input', function() {
                const minValue = parseFloat(this.value);
                const maxValue = parseFloat(document.getElementById('max_value_edit').value);

                if (minValue >= maxValue) {
                    document.getElementById('max_value_edit').setCustomValidity('Nilai maksimum harus lebih besar dari nilai minimum');
                } else {
                    document.getElementById('max_value_edit').setCustomValidity('');
                }
            });
        })();
    </script>
@endsection
