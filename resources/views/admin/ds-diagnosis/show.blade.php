@extends('admin.admin_main')
@section('title', 'Detail Diagnosis DS')

@section('admin_content')
    <div class="container mt-lg-5 p-lg-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Detail Diagnosis</h5>
                    <a href="{{ route('admin.ds-diagnosis.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- Diagnosis Info Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-clipboard2-pulse me-2"></i>
                            Informasi Diagnosis
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <strong>Tanggal:</strong>
                                <div class="text-muted">{{ $diagnosis->created_at->format('d F Y, H:i') }}</div>
                            </div>
                            <div class="col-md-3">
                                <strong>User:</strong>
                                <div class="text-muted">{{ $diagnosis->user->nama ?? 'Guest' }}</div>
                            </div>
                            <div class="col-md-3">
                                <strong>Nomor Telepon:</strong>
                                <div class="text-muted">{{ $diagnosis->user->telepon ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <strong>ID Diagnosis:</strong>
                                <div class="text-muted">#{{ $diagnosis->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Result Card -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-clipboard2-check me-2"></i>
                            Hasil Diagnosis
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Penyakit -->
                            <div class="col-md-6">
                                <div class="text-center p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-2">Penyakit Terdiagnosis</h6>
                                    <h5 class="text-primary mb-2">{{ $diagnosis->penyakit->penyakit }}</h5>
                                    <span class="badge bg-primary">{{ $diagnosis->penyakit->kode_penyakit }}</span>
                                </div>
                            </div>

                            <!-- Belief & Conflict -->
                            <div class="col-md-6">
                                <div class="text-center p-3 border rounded bg-light">
                                    <h6 class="text-muted mb-2">Nilai DS</h6>
                                    <div class="mb-2">
                                        <span class="badge bg-success">Belief: {{ number_format($diagnosis->belief_top, 4) }}</span>
                                    </div>
                                    <div>
                                        <span class="badge bg-warning">Conflict: {{ number_format($diagnosis->conflict_k, 5) }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">Confidence: {{ number_format($diagnosis->belief_top * 100, 1) }}%</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penanganan -->
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-clipboard2-heart me-2"></i>
                                Penanganan yang Disarankan
                            </h6>
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <i class="bi bi-info-circle me-3 mt-1"></i>
                                    <div>
                                        <strong>Rekomendasi:</strong>
                                        <p class="mb-0 mt-2">{{ $diagnosis->penyakit->penangan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 1: PERHITUNGAN FUZZY (DENSITAS) -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-calculator me-2"></i>
                            Bagian 1: Perhitungan Fuzzy Logic (Densitas)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Perhitungan densitas menggunakan metode Tsukamoto dengan input <strong>Kemunculan</strong> dan <strong>Keunikan</strong>.
                            Keunikan dihitung sebagai rata-rata dari semua penyakit yang memiliki gejala tersebut.
                        </p>

                        @if(isset($fuzzyDetails) && !empty($fuzzyDetails))
                            @foreach($fuzzyDetails as $gejalaId => $fuzzyDetail)
                                <div class="card mb-3 border-info">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">
                                            <span class="badge bg-secondary me-2">{{ $fuzzyDetail['gejala']->kode_gejala }}</span>
                                            {{ $fuzzyDetail['gejala']->gejala }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <!-- Input Fuzzy -->
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Input Fuzzy</h6>
                                                <table class="table table-sm table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td width="40%"><strong>Kemunculan:</strong></td>
                                                            <td>
                                                                <span class="badge bg-info">{{ $fuzzyDetail['kemunculan_label'] }}</span>
                                                                <span class="text-muted ms-2">(Nilai: {{ number_format($fuzzyDetail['kemunculan_nilai'], 2) }})</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Keunikan (Rata-rata):</strong></td>
                                                            <td>
                                                                <span class="badge bg-warning">{{ $fuzzyDetail['keunikan_label'] }}</span>
                                                                <span class="text-muted ms-2">(Nilai: {{ number_format($fuzzyDetail['keunikan_nilai'], 2) }})</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <!-- Detail Keunikan per Penyakit -->
                                                @if(!empty($fuzzyDetail['keunikan_detail']))
                                                    <div class="mt-3">
                                                        <small class="text-muted d-block mb-2"><strong>Detail Keunikan per Penyakit:</strong></small>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Penyakit</th>
                                                                        <th>Keunikan</th>
                                                                        <th>Nilai</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($fuzzyDetail['keunikan_detail'] as $keuDetail)
                                                                        <tr>
                                                                            <td>{{ $keuDetail['penyakit_nama'] }}</td>
                                                                            <td>
                                                                                <span class="badge bg-secondary">{{ $keuDetail['keunikan'] }}</span>
                                                                            </td>
                                                                            <td>{{ number_format($keuDetail['keunikan_nilai'], 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Output Fuzzy -->
                                            <div class="col-md-6">
                                                <h6 class="text-success mb-3">Output Fuzzy</h6>
                                                <div class="alert alert-success">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>Densitas (m):</strong>
                                                            <h4 class="mb-0 mt-2 text-success">{{ number_format($fuzzyDetail['densitas'], 4) }}</h4>
                                                        </div>
                                                        <div class="text-end">
                                                            <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">
                                                        Nilai densitas dihitung menggunakan aturan fuzzy Tsukamoto dengan kombinasi kemunculan dan keunikan.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Data perhitungan fuzzy tidak tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- BAGIAN 2: DEMPSTER-SHAFER (MASS FUNCTION & DS COMBINE) -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Bagian 2: Perhitungan Dempster-Shafer (Mass Function & DS Combine)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Perhitungan mass function untuk setiap gejala dan kombinasi evidence menggunakan rumus Dempster-Shafer.
                            Mass function didistribusikan ke penyakit berdasarkan keunikan, dan theta (θ) menunjukkan ketidaktahuan.
                        </p>

                        @if(isset($dsDetails) && !empty($dsDetails))
                            <!-- Mass Function per Gejala -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-list-ul me-2"></i>
                                    Mass Function per Gejala
                                </h5>

                                @if(isset($dsDetails['mass_functions']) && !empty($dsDetails['mass_functions']))
                                    @foreach($dsDetails['mass_functions'] as $gejalaId => $massData)
                                        <div class="card mb-3 border-warning">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">
                                                    <span class="badge bg-secondary me-2">{{ $massData['gejala_nama'] }}</span>
                                                    Densitas: <span class="badge bg-info">{{ number_format($massData['densitas'], 4) }}</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h6 class="text-success mb-3">Distribusi Mass ke Penyakit:</h6>
                                                        @if(isset($massData['mass_function']['penyakit']) && !empty($massData['mass_function']['penyakit']))
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Penyakit ID</th>
                                                                            <th>Mass (m)</th>
                                                                            <th>Persentase</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $totalMass = array_sum($massData['mass_function']['penyakit']);
                                                                        @endphp
                                                                        @foreach($massData['mass_function']['penyakit'] as $penyakitId => $mass)
                                                                            @php
                                                                                $penyakit = \App\Models\Penyakit::find($penyakitId);
                                                                            @endphp
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $penyakit ? $penyakit->kode_penyakit : "P{$penyakitId}" }}
                                                                                    @if($penyakit)
                                                                                        <br><small class="text-muted">{{ $penyakit->penyakit }}</small>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <span class="badge bg-success">{{ number_format($mass, 4) }}</span>
                                                                                </td>
                                                                                <td>
                                                                                    {{ number_format(($mass / $totalMass) * 100, 2) }}%
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning">
                                                                <small>Tidak ada distribusi mass ke penyakit.</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6 class="text-warning mb-3">Theta (θ) - Ketidaktahuan:</h6>
                                                        <div class="alert alert-warning">
                                                            <h4 class="mb-0">
                                                                m(θ) = {{ number_format($massData['mass_function']['theta'] ?? 0, 4) }}
                                                            </h4>
                                                            <small class="text-muted d-block mt-2">
                                                                Nilai ketidaktahuan yang tidak terdistribusikan ke penyakit tertentu.
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Proses Kombinasi DS -->
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-arrow-repeat me-2"></i>
                                    Proses Kombinasi Dempster-Shafer (Step by Step)
                                </h5>

                                @if(isset($dsDetails['combination_steps']) && !empty($dsDetails['combination_steps']))
                                    @foreach($dsDetails['combination_steps'] as $stepKey => $stepData)
                                        @php
                                            // Handle both 'result_mass' and 'mass_function' keys
                                            $massData = $stepData['result_mass'] ?? $stepData['mass_function'] ?? null;
                                        @endphp
                                        @if($massData && isset($massData['penyakit']) && !empty($massData['penyakit']))
                                            <div class="card mb-3 border-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h6 class="mb-0">
                                                        {{ ucfirst(str_replace('_', ' ', $stepKey)) }}: {{ $stepData['description'] ?? 'Kombinasi Evidence' }}
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    @if(isset($stepData['K']) && $stepData['K'] > 0)
                                                        <div class="alert alert-info mb-3">
                                                            <strong>Konflik (K) pada step ini:</strong>
                                                            <span class="badge bg-info">{{ number_format($stepData['K'], 5) }}</span>
                                                            <small class="text-muted d-block mt-1">
                                                                Nilai K ini adalah konflik yang terjadi pada kombinasi step ini dan digunakan untuk normalisasi.
                                                                K = Σ m1(X) × m2(Y) untuk semua X ∩ Y = ∅
                                                            </small>
                                                        </div>
                                                    @elseif(strpos($stepData['description'] ?? '', 'Inisialisasi') !== false)
                                                        <div class="alert alert-secondary mb-3">
                                                            <small class="text-muted">
                                                                <strong>Catatan:</strong> Step inisialisasi tidak memiliki konflik (K = 0) karena hanya ada satu evidence.
                                                            </small>
                                                        </div>
                                                    @endif
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Penyakit</th>
                                                                    <th>Mass setelah Kombinasi</th>
                                                                    <th>Persentase</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $totalMassAfter = array_sum($massData['penyakit']);
                                                                @endphp
                                                                @foreach($massData['penyakit'] as $penyakitKey => $mass)
                                                                    @php
                                                                        // Parse penyakit key (bisa single atau multiple)
                                                                        $penyakitIds = is_numeric($penyakitKey) ? [(int)$penyakitKey] : array_map('intval', explode(',', $penyakitKey));
                                                                        $penyakitNames = [];
                                                                        foreach($penyakitIds as $pid) {
                                                                            $p = \App\Models\Penyakit::find($pid);
                                                                            $penyakitNames[] = $p ? $p->penyakit : "P{$pid}";
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            @if(count($penyakitIds) == 1)
                                                                                @php $penyakit = \App\Models\Penyakit::find($penyakitIds[0]); @endphp
                                                                                {{ $penyakit ? $penyakit->kode_penyakit : "P{$penyakitIds[0]}" }}
                                                                                @if($penyakit)
                                                                                    <br><small class="text-muted">{{ $penyakit->penyakit }}</small>
                                                                                @endif
                                                                            @else
                                                                                { {{ implode(', ', $penyakitNames) }} }
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-primary">{{ number_format($mass, 4) }}</span>
                                                                        </td>
                                                                        <td>
                                                                            {{ $totalMassAfter > 0 ? number_format(($mass / $totalMassAfter) * 100, 2) : 0 }}%
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @if(isset($massData['theta']))
                                                                    <tr class="table-warning">
                                                                        <td><strong>θ (Ketidaktahuan)</strong></td>
                                                                        <td>
                                                                            <span class="badge bg-warning">{{ number_format($massData['theta'], 4) }}</span>
                                                                        </td>
                                                                        <td>
                                                                            {{ ($totalMassAfter + $massData['theta']) > 0 ? number_format(($massData['theta'] / ($totalMassAfter + $massData['theta'])) * 100, 2) : 0 }}%
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Catatan:</strong> Proses kombinasi tidak diperlukan karena hanya ada satu gejala yang dipilih.
                                        Mass function dari gejala tersebut langsung menjadi hasil akhir.
                                    </div>
                                @endif
                            </div>

                            <!-- Hasil Akhir -->
                            <div class="mb-4">
                                <h5 class="text-success mb-3">
                                    <i class="bi bi-trophy me-2"></i>
                                    Hasil Akhir - Belief untuk Setiap Penyakit
                                </h5>

                                @if(isset($dsDetails['final_results']['penyakit_beliefs']) && !empty($dsDetails['final_results']['penyakit_beliefs']))
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-success">
                                                <tr>
                                                    <th>Rank</th>
                                                    <th>Penyakit</th>
                                                    <th>Kode</th>
                                                    <th>Belief (m)</th>
                                                    <th>Persentase</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sortedBeliefs = $dsDetails['final_results']['penyakit_beliefs'];
                                                    arsort($sortedBeliefs);
                                                    $rank = 1;
                                                    $maxBelief = max($sortedBeliefs);
                                                @endphp
                                                @foreach($sortedBeliefs as $penyakitId => $belief)
                                                    @if($belief > 0)
                                                        @php
                                                            $penyakit = \App\Models\Penyakit::find($penyakitId);
                                                            $isDiagnosis = ($penyakit && $penyakit->id == $diagnosis->penyakit_id);
                                                        @endphp
                                                        <tr class="{{ $isDiagnosis ? 'table-success' : '' }}">
                                                            <td>
                                                                <span class="badge bg-{{ $rank == 1 ? 'success' : 'secondary' }}">{{ $rank }}</span>
                                                            </td>
                                                            <td>
                                                                @if($penyakit)
                                                                    {{ $penyakit->penyakit }}
                                                                @else
                                                                    Penyakit ID: {{ $penyakitId }}
                                                                @endif
                                                                @if($isDiagnosis)
                                                                    <span class="badge bg-success ms-2">Diagnosis Utama</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($penyakit)
                                                                    <span class="badge bg-primary">{{ $penyakit->kode_penyakit }}</span>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <strong class="text-success">{{ number_format($belief, 4) }}</strong>
                                                            </td>
                                                            <td>
                                                                <div class="progress" style="height: 20px;">
                                                                    <div class="progress-bar bg-success" role="progressbar"
                                                                         style="width: {{ ($belief / $maxBelief) * 100 }}%"
                                                                         aria-valuenow="{{ $belief }}"
                                                                         aria-valuemin="0"
                                                                         aria-valuemax="{{ $maxBelief }}">
                                                                        {{ number_format(($belief / $maxBelief) * 100, 1) }}%
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if($isDiagnosis)
                                                                    <span class="badge bg-success">
                                                                        <i class="bi bi-check-circle me-1"></i>Terpilih
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $rank++; @endphp
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <!-- Informasi Konflik -->
                                @if(isset($dsDetails['final_results']['total_conflict']))
                                    <div class="alert alert-info mt-3">
                                        <h6 class="alert-heading">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Total Konflik (K) - Dari Kombinasi Terakhir
                                        </h6>
                                        <p class="mb-0">
                                            <strong>K = {{ number_format($dsDetails['final_results']['total_conflict'], 5) }}</strong>
                                        </p>
                                        <small class="text-muted">
                                            <strong>Keterangan:</strong> Nilai K ini adalah konflik (K) dari kombinasi Dempster-Shafer terakhir yang digunakan untuk normalisasi hasil akhir.
                                            K dihitung sebagai jumlah dari m1(X) × m2(Y) untuk semua X ∩ Y = ∅ (intersection kosong).
                                            Semakin tinggi nilai K, semakin tinggi ketidaksesuaian antara evidence dan semakin tinggi ketidakpastian dalam sistem.
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Data perhitungan Dempster-Shafer tidak tersedia.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center">
                    <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-printer me-1"></i>Cetak Laporan
                    </button>
                    <a href="{{ route('admin.ds-diagnosis.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
    @media print {
        .btn, .card-header {
            display: none !important;
        }

        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
        }

        .badge {
            border: 1px solid #000 !important;
        }
    }
    </style>
@endsection
