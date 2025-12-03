@extends('admin.admin_main')
@section('title', 'Aturan Fuzzy')

@section('admin_content')
    <div class="container mt-lg-5 p-lg-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Manajemen Aturan Fuzzy</h5>
                    <a href="{{ route('admin.fuzzy-rules.explanation') }}" class="btn btn-outline-info">
                        <i class="bi bi-info-circle me-1"></i> Penjelasan
                    </a>
                </div>

                <!-- Info Card -->
                <div class="alert alert-info">
                    <div class="d-flex">
                        <i class="bi bi-info-circle me-3 mt-1"></i>
                        <div>
                            <h6 class="alert-heading">Sistem Fuzzy-Dempster Shafer</h6>
                            <p class="mb-0">
                                Aturan fuzzy ini digunakan dalam metode Tsukamoto untuk menghitung nilai densitas gejala.
                                Nilai densitas kemudian digunakan sebagai input untuk kombinasi Dempster-Shafer.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fuzzy Rules Table -->
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Aturan Fuzzy untuk Perhitungan Densitas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kemunculan</th>
                                        <th>Keunikan</th>
                                        <th>Output Densitas</th>
                                        <th>Deskripsi Aturan</th>
                                        <th>Visualisasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fuzzyRules as $rule)
                                        <tr>
                                            <td>{{ $rule['id'] }}</td>
                                            <td>
                                                @php
                                                    $kemunculanColor = match($rule['kemunculan']) {
                                                        'Sangat Jarang' => 'danger',
                                                        'Kadang-Kadang' => 'warning',
                                                        'Sering' => 'success',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $kemunculanColor }}">{{ $rule['kemunculan'] }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $keunikanColor = match($rule['keunikan']) {
                                                        'Tinggi' => 'success',
                                                        'Sedang' => 'warning',
                                                        'Rendah' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $keunikanColor }}">{{ $rule['keunikan'] }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 100px; height: 20px;">
                                                        <div class="progress-bar
                                                            @if($rule['output'] >= 0.7) bg-success
                                                            @elseif($rule['output'] >= 0.4) bg-warning
                                                            @else bg-danger
                                                            @endif"
                                                            role="progressbar"
                                                            style="width: {{ $rule['output'] * 100 }}%"
                                                            aria-valuenow="{{ $rule['output'] }}"
                                                            aria-valuemin="0"
                                                            aria-valuemax="1">
                                                        </div>
                                                    </div>
                                                    <span class="badge bg-primary">{{ number_format($rule['output'], 2) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $rule['description'] }}</small>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    @php
                                                        $outputLabel = match(true) {
                                                            $rule['output'] >= 0.8 => 'Sangat Tinggi',
                                                            $rule['output'] >= 0.6 => 'Tinggi',
                                                            $rule['output'] >= 0.4 => 'Sedang',
                                                            $rule['output'] >= 0.2 => 'Rendah',
                                                            default => 'Sangat Rendah'
                                                        };
                                                        $outputColor = match(true) {
                                                            $rule['output'] >= 0.8 => 'success',
                                                            $rule['output'] >= 0.6 => 'info',
                                                            $rule['output'] >= 0.4 => 'warning',
                                                            $rule['output'] >= 0.2 => 'danger',
                                                            default => 'dark'
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $outputColor }}">{{ $outputLabel }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Input Values Reference -->
                <div class="card shadow mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-table me-2"></i>
                            Nilai Input Fuzzy (Dinamis dari Database)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Kemunculan Gejala</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($kemunculanParams as $param)
                                        @php
                                            $color = match(true) {
                                                $param->nilai >= 0.7 => 'success',
                                                $param->nilai >= 0.4 => 'warning',
                                                default => 'danger'
                                            };
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $param->label }}
                                            <span class="badge bg-{{ $color }}">{{ number_format($param->nilai, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Keunikan Gejala</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($keunikanParams as $param)
                                        @php
                                            $color = match(true) {
                                                $param->nilai >= 0.7 => 'success',
                                                $param->nilai >= 0.4 => 'warning',
                                                default => 'danger'
                                            };
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $param->label }}
                                            <span class="badge bg-{{ $color }}">{{ number_format($param->nilai, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Catatan:</strong> Nilai-nilai di atas diambil secara dinamis dari database.
                                Untuk mengubah nilai, silakan edit di menu <a href="{{ route('fuzzy-parameters.index') }}" class="alert-link">Parameter Fuzzy</a>.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
