@extends('admin.admin_main')
@section('title', 'Gejala')

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
                        <h5 class="mb-0">Master Gejala</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#storeModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Gejala
                        </button>
                    </div>

                    <div class="table-responsive shadow-sm rounded">
                        <table id="tabel-gejala" class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Gejala</th>
                                    <th>Pertanyaan</th>
                                    <th>Aktif</th>
                                    <th>Urutan</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gejala as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $gejala->firstItem() - 1 }}</td>
                                        <td><span class="badge bg-secondary">{{ $item->kode_gejala }}</span></td>
                                        <td class="text-wrap">{{ $item->gejala }}</td>
                                        <td class="text-wrap text-muted" style="max-width: 280px;">{{ $item->pertanyaan ?? '-' }}</td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-outline-secondary border">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->urutan ?? '-' }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                onclick="updateInput('{{ route('gejala.update', ':id') }}','{{ $item->id }}', '{{ $item->kode_gejala }}', '{{ $item->gejala }}', `{{ $item->pertanyaan }}`, {{ $item->is_active ? 1 : 0 }}, `{{ $item->urutan }}`)">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('gejala.destroy', $item->id) }}" method="post" class="d-inline form-delete-gejala" data-nama="{{ $item->gejala }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->gejala }}">
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
                            Menampilkan {{ $gejala->firstItem() }}–{{ $gejala->lastItem() }} dari {{ $gejala->total() }} data
                        </div>
                        <div>
                            @if ($gejala->onFirstPage())
                                <span class="btn btn-secondary disabled btn-sm">« Sebelumnya</span>
                            @else
                                <a href="{{ $gejala->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">« Sebelumnya</a>
                            @endif

                            @if ($gejala->hasMorePages())
                                <a href="{{ $gejala->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">Berikutnya »</a>
                            @else
                                <span class="btn btn-secondary disabled btn-sm">Berikutnya »</span>
                            @endif
                        </div>
                    </div>
                    @include('components.admin_modal_gejala_edit')
                </div>
            </div>
        </div>
        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah yakin ingin menghapus gejala <strong id="deleteGejalaName">-</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnConfirmDelete">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            (function(){
                function bindDeleteHandlers(){
                    let formToSubmit = null;
                    const modalEl = document.getElementById('deleteConfirmModal');
                    const nameEl = document.getElementById('deleteGejalaName');
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
                                if (confirm('Apakah yakin ingin menghapus gejala ' + nama + ' ?')) {
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
