@extends('admin.admin_main')
@section('title', 'Aturan DS')

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
                    <h5 class="mb-0">Relasi Gejala-Penyakit</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dsRuleCreateModal">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Relasi
                    </button>
                </div>

                <!-- Info Card -->
                <div class="alert alert-info">
                    <div class="d-flex">
                        <i class="bi bi-info-circle me-3 mt-1"></i>
                        <div>
                            <h6 class="alert-heading">Relasi Gejala-Penyakit dalam Sistem Fuzzy-DS</h6>
                            <p class="mb-0">
                                Relasi ini mendefinisikan hubungan antara gejala dan penyakit dalam sistem diagnosis.
                                Nilai densitas akan dihitung secara otomatis menggunakan fuzzy logic berdasarkan
                                tingkat kemunculan gejala dan tingkat keunikan gejala.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive shadow-sm rounded">
                    <table id="tabel-ds-rules" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Penyakit</th>
                                <th>Gejala</th>
                                <th>Keunikan</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dsRules as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $dsRules->firstItem() - 1 }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->penyakit->kode_penyakit }}</span>
                                        <div class="small text-muted">{{ $item->penyakit->penyakit }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $item->gejala->kode_gejala }}</span>
                                        <div class="small text-muted">{{ $item->gejala->gejala }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $keunikanClass = match($item->keunikan) {
                                                'Tinggi' => 'bg-danger',
                                                'Sedang' => 'bg-warning',
                                                'Rendah' => 'bg-info',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $keunikanClass }}">{{ $item->keunikan }}</span>
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            {{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit-dsrule"
                                            data-bs-toggle="modal" data-bs-target="#dsRuleEditModal"
                                            data-action="{{ route('ds-rules.update', ':ds_rule') }}"
                                            data-id="{{ $item->id }}"
                                            data-penyakit="{{ $item->penyakit_id }}"
                                            data-gejala="{{ $item->gejala_id }}"
                                            data-keunikan="{{ $item->keunikan }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-is-active="{{ $item->is_active }}"
                                            data-show="{{ route('ds-rules.show', $item->id) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('ds-rules.destroy', $item->id) }}" class="d-inline form-delete-dsrule" method="POST" data-nama="{{ $item->penyakit->penyakit }} - {{ $item->gejala->gejala }}">
                                            @method('DELETE')
                                            @csrf()
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->penyakit->penyakit }} - {{ $item->gejala->gejala }}">
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
                        Menampilkan {{ $dsRules->firstItem() }}–{{ $dsRules->lastItem() }} dari {{ $dsRules->total() }} data
                    </div>
                    <div>
                        @if ($dsRules->onFirstPage())
                            <span class="btn btn-secondary disabled btn-sm">« Sebelumnya</span>
                        @else
                            <a href="{{ $dsRules->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">« Sebelumnya</a>
                        @endif

                        @if ($dsRules->hasMorePages())
                            <a href="{{ $dsRules->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">Berikutnya »</a>
                        @else
                            <span class="btn btn-secondary disabled btn-sm">Berikutnya »</span>
                        @endif
                    </div>
                </div>

                <!-- System Flow Explanation -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-diagram-3 me-2"></i>
                                    Alur Sistem Fuzzy-Dempster Shafer
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="flow-steps">
                                            <div class="step">
                                                <div class="step-number">1</div>
                                                <div class="step-content">
                                                    <h6>Input Pengguna</h6>
                                                    <p class="small mb-0">User memilih gejala dan tingkat kemunculan (Sangat Jarang/Kadang-Kadang/Sering)</p>
                                                </div>
                                            </div>
                                            <div class="step">
                                                <div class="step-number">2</div>
                                                <div class="step-content">
                                                    <h6>Fuzzy Logic (Tsukamoto)</h6>
                                                    <p class="small mb-0">Menghitung nilai densitas berdasarkan kemunculan + keunikan gejala</p>
                                                </div>
                                            </div>
                                            <div class="step">
                                                <div class="step-number">3</div>
                                                <div class="step-content">
                                                    <h6>Dempster-Shafer</h6>
                                                    <p class="small mb-0">Menggunakan relasi gejala-penyakit untuk kombinasi evidence dari fuzzy</p>
                                                </div>
                                            </div>
                                            <div class="step">
                                                <div class="step-number">4</div>
                                                <div class="step-content">
                                                    <h6>Hasil Diagnosis</h6>
                                                    <p class="small mb-0">3 penyakit dengan belief tertinggi + diagnosis utama</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-light">
                                            <h6 class="alert-heading">Peran Relasi Gejala-Penyakit</h6>
                                            <p class="small mb-0">
                                                Relasi ini mendefinisikan hubungan antara gejala dan penyakit.
                                                Sistem akan menggunakan relasi ini untuk menentukan penyakit mana
                                                yang mungkin berdasarkan gejala yang dipilih pengguna.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteDsRuleModal" tabindex="-1" aria-labelledby="deleteDsRuleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDsRuleLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah yakin ingin menghapus aturan <strong id="deleteDsRuleName">-</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnConfirmDeleteDsRule">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('components.admin_modal_dsrule_edit')

    <script>
        (function(){
            // Edit DS Rule Modal
            const editModalEl = document.getElementById('dsRuleEditModal');
            const editForm = document.getElementById('ds-rule-edit-form');
            const penyakitSelect = document.getElementById('penyakit_id_edit');
            const gejalaSelect = document.getElementById('gejala_id_edit');
            const keunikanSelect = document.getElementById('keunikan_edit');
            const deskripsiInput = document.getElementById('deskripsi_edit');
            const isActiveCheckbox = document.getElementById('is_active_edit');
            const idInput = document.getElementById('id_dsrule_edit');

            document.querySelectorAll('.btn-edit-dsrule').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const actionUrl = this.dataset.action.replace(':ds_rule', id);
                    const showUrl = this.dataset.show;

                    editForm.setAttribute('action', actionUrl);
                    idInput.value = id;

                    // Debug: log the action URL
                    console.log('Edit form action set to:', actionUrl);

                    // Store the edit ID in localStorage for error recovery
                    localStorage.setItem('dsRuleEditId', id);

                    fetch(showUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Always populate form with original database values
                            penyakitSelect.value = data.penyakit_id || '';
                            gejalaSelect.value = data.gejala_id || '';
                            keunikanSelect.value = data.keunikan || '';
                            deskripsiInput.value = data.deskripsi || '';
                            isActiveCheckbox.checked = data.is_active || false;
                        })
                        .catch(error => {
                            console.error('Error fetching DS rule data:', error);
                            // Fallback to data attributes if fetch fails
                            penyakitSelect.value = this.dataset.penyakit || '';
                            gejalaSelect.value = this.dataset.gejala || '';
                            keunikanSelect.value = this.dataset.keunikan || '';
                            deskripsiInput.value = this.dataset.deskripsi || '';
                            isActiveCheckbox.checked = this.dataset.isActive === 'true' || false;
                        });
                });
            });

            // Delete DS Rule Modal
            const deleteModalEl = document.getElementById('deleteDsRuleModal');
            if (deleteModalEl && deleteModalEl.parentNode !== document.body) {
                document.body.appendChild(deleteModalEl);
            }

            let formToSubmit = null;
            const nameEl = document.getElementById('deleteDsRuleName');
            const btnConfirm = document.getElementById('btnConfirmDeleteDsRule');

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
                        if (confirm('Apakah yakin ingin menghapus aturan ' + nama + ' ?')) {
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
        })();
    </script>

    <style>
        .flow-steps {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .step-content h6 {
            margin-bottom: 0.25rem;
            color: #333;
        }

        .step-content p {
            color: #666;
        }

        @media (max-width: 768px) {
            .flow-steps {
                gap: 0.75rem;
            }

            .step {
                gap: 0.75rem;
            }

            .step-number {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }
    </style>
@endsection
