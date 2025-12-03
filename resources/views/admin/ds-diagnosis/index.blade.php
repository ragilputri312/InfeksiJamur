@extends('admin.admin_main')
@section('title', 'Hasil Diagnosis')

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

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Hasil Diagnosis Autoimun</h5>
                </div>

                <div class="table-responsive shadow-sm rounded">
                    <table id="tabel-ds-diagnosis" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Penyakit</th>
                                <th>Belief</th>
                                <th>Conflict</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diagnoses as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $diagnoses->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="small">{{ $item->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted">{{ $item->created_at->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-fill me-2 text-primary"></i>
                                            <div>
                                                <div class="fw-medium">{{ $item->user->nama ?? 'Guest' }}</div>
                                                <div class="small text-muted">{{ $item->user->telepon ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->penyakit->kode_penyakit }}</span>
                                        <div class="small text-muted">{{ $item->penyakit->penyakit }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ number_format($item->belief_top * 100, 1) }}%</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ number_format($item->conflict_k, 3) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.ds-diagnosis.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="small text-muted">
                        Menampilkan {{ $diagnoses->firstItem() }}–{{ $diagnoses->lastItem() }} dari {{ $diagnoses->total() }} data
                    </div>
                    <div>
                        @if ($diagnoses->onFirstPage())
                            <span class="btn btn-secondary disabled btn-sm">« Sebelumnya</span>
                        @else
                            <a href="{{ $diagnoses->previousPageUrl() }}" class="btn btn-outline-primary btn-sm">« Sebelumnya</a>
                        @endif

                        @if ($diagnoses->hasMorePages())
                            <a href="{{ $diagnoses->nextPageUrl() }}" class="btn btn-outline-primary btn-sm">Berikutnya »</a>
                        @else
                            <span class="btn btn-secondary disabled btn-sm">Berikutnya »</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
