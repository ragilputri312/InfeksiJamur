@extends('admin.admin_main')
@section('title', 'Hasil Diagnosa')

{{-- isi --}}
@section('admin_content')
    <!-- Page content-->
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-hover mt-2 p-2">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Diagnosa ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Gejala</th>
                            <th scope="col">Penyakit</th>
                            <th scope="col">Persentase</th>
                            <th scope="col">Detail</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($diagnosis as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->diagnosis_id }}</td>
                                    <td>{{ $item->nama }}</td> <!-- Nama akun -->
                                    <td>
                                        @foreach ($item->gejala as $g)
                                            {{ $g['gejala_nama'] }} <br> <!-- Nama gejala -->
                                        @endforeach
                                    </td>
                                    <td>{{ $item->penyakit }}</td> <!-- Nama penyakit -->
                                    <td>{{ $item->persentase }}%</td> <!-- Persentase -->
                                    <td>
                                        <button onclick="redirectToDiagnosisResult({{ json_encode($item->diagnosis_id) }})" class="btn btn-primary">Detail</button>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main><!-- End #main -->


    <script>
    function redirectToDiagnosisResult(diagnosis_id) {
        // Redirect ke halaman hasil diagnosis
        window.location.href = "{{ route('diagnosis.result', ['diagnosis_id' => ':diagnosis_id']) }}".replace(':diagnosis_id', diagnosis_id);
    }
</script>

@endsection
