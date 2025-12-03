@extends('admin.admin_main')
@section('title', 'Penyakit')

{{-- isi --}}
@section('admin_content')
    <!-- Page content-->
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
                <h5 class="mb-0">Master Penyakit</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#penyakitCreateModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Penyakit
                </button>
            </div>

            <div class="table-responsive shadow-sm rounded">
                <table id="tabel-penyakit" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Penyakit</th>
                        <th>Penanganan</th>
                        <th class="text-end">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($penyakit as $item)
                            <tr>
                                <td>{{ $loop->iteration + $penyakit->firstItem() - 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $item->kode_penyakit }}</span></td>
                                <td class="text-wrap">{{ $item->penyakit }}</td>
                                <td class="text-wrap" style="max-width: 380px; white-space: pre-line;">{!! nl2br(e($item->penangan)) !!}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit-penyakit"
                                        data-action="{{ route('penyakit.update', ':id') }}"
                                        data-show="{{ route('penyakit.show', ':id') }}"
                                        data-id="{{ $item->id }}"
                                        data-kode="{{ $item->kode_penyakit }}"
                                        data-nama="{{ $item->penyakit }}"
                                        data-penangan="{{ $item->penangan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('penyakit.destroy', $item->id) }}" class="d-inline form-delete-penyakit" method="POST" data-nama="{{ $item->penyakit }}">
                                        @method('DELETE')
                                        @csrf()
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-trigger" data-nama="{{ $item->penyakit }}">
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
                    Menampilkan {{ $penyakit->firstItem() }}–{{ $penyakit->lastItem() }} dari {{ $penyakit->total() }} data
                </div>
                <div>
                    @if ($penyakit->onFirstPage())
                        <span class="btn btn-secondary disabled btn-sm">« Sebelumnya</span>
                    @else
                        <a href="{{ $penyakit->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">« Sebelumnya</a>
                    @endif

                    @if ($penyakit->hasMorePages())
                        <a href="{{ $penyakit->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">Berikutnya »</a>
                    @else
                        <span class="btn btn-secondary disabled btn-sm">Berikutnya »</span>
                    @endif
                </div>
            </div>

              @include('components.admin_modal_penyakit_edit')
          </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deletePenyakitModal" tabindex="-1" aria-labelledby="deletePenyakitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePenyakitLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah yakin ingin menghapus penyakit <strong id="deletePenyakitName">-</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnConfirmDeletePenyakit">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            // move modal to body
            const modalEl = document.getElementById('deletePenyakitModal');
            if (modalEl && modalEl.parentNode !== document.body) {
                document.body.appendChild(modalEl);
            }

            let formToSubmit = null;
            const nameEl = document.getElementById('deletePenyakitName');
            const btnConfirm = document.getElementById('btnConfirmDeletePenyakit');

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
                        if (confirm('Apakah yakin ingin menghapus penyakit ' + nama + ' ?')) {
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

        (function(){
            const editModalEl = document.getElementById('penyakitEditModal');
            const form = document.getElementById('penyakit-edit-form');
            const kodeEl = document.getElementById('kode-penyakit');
            const namaEl = document.getElementById('penyakit-nama');
            const penEl = document.getElementById('penangan');
            const idEl = document.getElementById('id_penyakit');
            document.querySelectorAll('.btn-edit-penyakit').forEach(function(btn){
                btn.addEventListener('click', function(){
                    const actionTpl = btn.getAttribute('data-action') || '';
                    const showTpl = btn.getAttribute('data-show') || '';
                    const id = btn.getAttribute('data-id') || '';
                    const kode = btn.getAttribute('data-kode') || '';
                    const nama = btn.getAttribute('data-nama') || '';
                    const penangan = btn.getAttribute('data-penangan') || '';
                    if (form) {
                        form.setAttribute('action', actionTpl.replace(':id', id));
                        form.setAttribute('method', 'POST');
                    }
                    // Prefer fetch detail to avoid attribute escaping issues
                    const url = showTpl.replace(':id', id);
                    fetch(url, { headers: { 'Accept': 'application/json' } })
                      .then(r => r.ok ? r.json() : null)
                      .then(data => {
                          if (data) {
                              if (kodeEl) kodeEl.value = data.kode_penyakit ?? kode;
                              if (namaEl) namaEl.value = data.penyakit ?? nama;
                              if (penEl) penEl.value = data.penangan ?? penangan;
                          } else {
                              if (kodeEl) kodeEl.value = kode;
                              if (namaEl) namaEl.value = nama;
                              if (penEl) penEl.value = penangan;
                          }
                          if (idEl) idEl.value = id;
                          if (window.bootstrap && bootstrap.Modal) {
                              const bsModal = new bootstrap.Modal(editModalEl);
                              bsModal.show();
                          } else {
                              editModalEl.style.display = 'block';
                          }
                      })
                      .catch(() => {
                          if (kodeEl) kodeEl.value = kode;
                          if (namaEl) namaEl.value = nama;
                          if (penEl) penEl.value = penangan;
                          if (idEl) idEl.value = id;
                          if (window.bootstrap && bootstrap.Modal) {
                              const bsModal = new bootstrap.Modal(editModalEl);
                              bsModal.show();
                          } else {
                              editModalEl.style.display = 'block';
                          }
                      });
                });
            });
        })();
    </script>

@endsection
