@extends('clients.cl_main')
@section('title', 'Form Diagnosa')

@section('cl_content')

    <!-- Section 1 -->
    <div class="col-lg-10 mx-auto equal-height">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Diagnosis ID</th>
                        <th scope="col">Penyakit</th>
                        <th scope="col">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $diagnosis->diagnosis_id }}</td>
                        <td> {{ $diagnosis_dipilih["kode_penyakit"]->kode_penyakit }} | {{ $diagnosis_dipilih["kode_penyakit"]->penyakit }} </td>
                        <td> {{ ($diagnosis_dipilih["value"] * 100) }} % </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Section 2 -->
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="d-flex flex-wrap justify-content-center">
                    <!-- Table Pakar -->
                    <table class="table table-hover mt-5 border border-primary p-3 mx-3">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">Pakar</th>
                            </tr>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Gejala</th>
                                <th scope="col">Nilai (MB - MD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pakar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $item->kode_gejala }} | {{ $item->kode_penyakit }}
                                    </td>
                                    <td>{{ $item->mb - $item->md }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Table User -->
                    <table class="table table-hover mt-5 border border-danger p-3 mx-3">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">User</th>
                            </tr>
                            <tr>
                                <th scope="col">Gejala</th>
                                <th scope="col">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gejala_by_user as $key)
                            <tr>
                                <td>{{ $key[0] }}</td>
                                <td>{{ $key[1] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Table CF Gabungan -->
                    <table class="table table-hover mt-5 border border-info p-3 mx-3">
                        <thead>
                            <tr>
                                <th class="text-center">Hasil</th>
                            </tr>
                            <tr>
                                <th scope="col">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cf_kombinasi["cf"] as $key)
                            <tr>
                                <td>{{ $key }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="row">
            <div class="col-md-10 mx-auto equal-height">
                <div class="card my-4">
                    <div class="card-header">
                        Hasil
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        {{ $diagnosis_dipilih["kode_penyakit"]->kode_penyakit }} | {{ $diagnosis_dipilih["kode_penyakit"]->penyakit }}
                        </h5>
                      <p class="card-text">Jadi dapat disimpulkan bahwa pasien mengalami infeksi jamur yaitu <span class="fw-semibold fs-4">{{ round(($hasil["value"] * 100), 2) }}</span> %</p>
                      {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-3">
            <button class="btn-print" onclick="window.print()">PRINT HASIL</button>
        </div>
@endsection
