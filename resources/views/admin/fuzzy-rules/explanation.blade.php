@extends('admin.admin_main')
@section('title', 'Penjelasan Fuzzy Logic')

@section('admin_content')
    <div class="container mt-lg-5 p-lg-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ $explanation['title'] }}</h5>
                    <a href="{{ route('admin.fuzzy-rules.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @foreach($explanation['sections'] as $section)
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                {{ $section['title'] }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">{{ $section['content'] }}</p>
                            <ul class="list-group list-group-flush">
                                @foreach($section['items'] as $item)
                                    <li class="list-group-item">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <!-- Algorithm Flow -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Algoritma Metode Tsukamoto
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="badge bg-warning text-dark fs-6 mb-2">1</div>
                                    <h6 class="text-muted mb-1">Input</h6>
                                    <small class="text-muted">Kemunculan & Keunikan</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="badge bg-primary fs-6 mb-2">2</div>
                                    <h6 class="text-muted mb-1">Fuzzification</h6>
                                    <small class="text-muted">Derajat Keanggotaan</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="badge bg-info fs-6 mb-2">3</div>
                                    <h6 class="text-muted mb-1">Rule Evaluation</h6>
                                    <small class="text-muted">Operator AND (Min)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="badge bg-success fs-6 mb-2">4</div>
                                    <h6 class="text-muted mb-1">Defuzzification</h6>
                                    <small class="text-muted">Nilai Crisp Output</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mathematical Formula -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-calculator me-2"></i>
                            Rumus Perhitungan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Metode Tsukamoto</h6>
                                <div class="bg-light p-3 rounded">
                                    <code>
                                        y = (Σ(αi × zi)) / Σαi
                                    </code>
                                    <br><br>
                                    <small class="text-muted">
                                        Dimana:<br>
                                        • αi = derajat keanggotaan hasil aturan ke-i<br>
                                        • zi = output crisp aturan ke-i<br>
                                        • y = output final
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Dempster-Shafer Combination</h6>
                                <div class="bg-light p-3 rounded">
                                    <code>
                                        m3(A) = [Σ m1(B)×m2(C)] / (1-K)
                                    </code>
                                    <br><br>
                                    <small class="text-muted">
                                        Dimana:<br>
                                        • K = konflik evidence<br>
                                        • m1, m2 = mass function<br>
                                        • m3 = hasil kombinasi
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example Calculation -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="bi bi-lightbulb me-2"></i>
                            Contoh Perhitungan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Contoh:</strong> Gejala dengan kemunculan "Sering" dan keunikan "Tinggi"
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h6 class="text-primary">Input</h6>
                                    <ul class="list-unstyled">
                                        <li>Kemunculan: <span class="badge bg-success">Sering (0.8)</span></li>
                                        <li>Keunikan: <span class="badge bg-success">Tinggi (0.8)</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h6 class="text-primary">Aturan Fuzzy</h6>
                                    <p class="mb-0">
                                        IF Kemunculan = Sering AND Keunikan = Tinggi<br>
                                        THEN Densitas = Sangat Tinggi
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <h6 class="text-primary">Output</h6>
                                    <ul class="list-unstyled">
                                        <li>Densitas: <span class="badge bg-success">0.9</span></li>
                                        <li>Kategori: <span class="badge bg-success">Sangat Tinggi</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
