@extends('admin.admin_main')
@section('title', 'Gejala')

@section('admin_content')
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
                            <i class="bi bi-plus-circle-fill"> Tambah Gejala</i>
                        </button>
                    </div>
                    <table id="tabel-gejala" class="table table-bordered table-hover my-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Gejala</th>
                                <th scope="col">Gejala</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gejala as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration + $gejala->firstItem() - 1 }}</th>
                                    <td>{{ $item->kode_gejala }}</td>
                                    <td>{{ $item->gejala }}</td>
                                    <td>
                                        <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="updateInput('{{ route('gejala.update', ':id') }}','{{ $item->id }}', '{{ $item->kode_gejala }}', '{{ $item->gejala }}')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('gejala.destroy', $item->id) }}" method="post" class="d-inline">
                                            @method('DELETE')
                                            @csrf
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
                            Showing {{ $gejala->firstItem() }} to {{ $gejala->lastItem() }} of {{ $gejala->total() }} results
                        </div>

                        {{-- Previous & Next Buttons --}}
                        <div>
                            @if ($gejala->onFirstPage())
                                <span class="btn btn-secondary disabled">« Previous</span>
                            @else
                                <a href="{{ $gejala->previousPageUrl() }}" class="btn btn-primary">« Previous</a>
                            @endif

                            @if ($gejala->hasMorePages())
                                <a href="{{ $gejala->nextPageUrl() }}" class="btn btn-primary">Next »</a>
                            @else
                                <span class="btn btn-secondary disabled">Next »</span>
                            @endif
                        </div>
                    </div>
                    @include('components.admin_modal_gejala_edit')
                </div>
            </div>
        </div>
@endsection
