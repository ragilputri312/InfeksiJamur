@extends('admin.admin_main')
@section('title', 'Penyakit')

{{-- isi --}}
@section('admin_content')
    <!-- Page content-->
    <div class="container text-center mt-lg-5 p-lg-5">
        <div class="row">
          <div class="col-lg-8 justify-content-center mx-auto">
            <!-- Pesan Sukses -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pesan Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-2 pt-3 d-flex ms-auto">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#storeModal">
                    <i class="bi bi-plus-circle-fill"> Tambah Penyakit</i>
                </button>
            </div>
            <table id="tabel-penyakit" class="table table-bordered table-hover my-2">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode Penyakit</th>
                    <th scope="col">Penyakit</th>
                    <th scope="col">Penanganan</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($penyakit as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $penyakit->firstItem() - 1 }}</th>
                            <td>{{ $item->kode_penyakit }}</td>
                            <td>{{ $item->penyakit }}</td>
                            <td>{{ $item->penangan }}</td>
                            <td>
                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="updateInput('{{ route('penyakit.update', ':id') }}', '{{ $item->id }}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                                <form action="{{ route('penyakit.destroy', $item->id) }}" class="d-inline" method="POST">
                                    @method('DELETE')
                                    @csrf()
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
              {{-- Manual Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                {{-- Showing X to Y of Z results --}}
                <div>
                    Showing {{ $penyakit->firstItem() }} to {{ $penyakit->lastItem() }} of {{ $penyakit->total() }} results
                </div>

                {{-- Previous & Next Buttons --}}
                <div>
                    @if ($penyakit->onFirstPage())
                        <span class="btn btn-secondary disabled">« Previous</span>
                    @else
                        <a href="{{ $penyakit->previousPageUrl() }}" class="btn btn-primary">« Previous</a>
                    @endif

                    @if ($penyakit->hasMorePages())
                        <a href="{{ $penyakit->nextPageUrl() }}" class="btn btn-primary">Next »</a>
                    @else
                        <span class="btn btn-secondary disabled">Next »</span>
                    @endif
                </div>
            </div>
              @include('components.admin_modal_penyakit_edit')
          </div>
        </div>
    </div>

@endsection
