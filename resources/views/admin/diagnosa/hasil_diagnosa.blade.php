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
                            <th scope="col">Tingkat Depresi</th>
                            <th scope="col">Persentase</th>
                          </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <th scope="row">loop->iteration</th>
                                    <td>item->diagnosa_id</td>
                                    <td>diagnosa_dipilih["kode_depresi"]->kode_depresi  | diagnosa_dipilih["kode_depresi"]->depresi </td>
                                    <td>diagnosa_dipilih["value"] * 100 %</td>
                                    <td><a class="p-2" href="#">Detail</a></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
