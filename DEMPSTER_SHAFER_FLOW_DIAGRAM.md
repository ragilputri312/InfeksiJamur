# Diagram Alur Kombinasi Evidence Dempster-Shafer

## 1. Input: Densitas Results
```
Densitas Results = {
    gejala_1: {densitas: 0.8},
    gejala_2: {densitas: 0.6},
    gejala_3: {densitas: 0.7}
}
```

## 2. Hitung Mass Function untuk Setiap Penyakit

### Untuk Penyakit A:
```
Rules: gejala_1 -> Penyakit A (keunikan: Tinggi)
       gejala_2 -> Penyakit A (keunikan: Sedang)

Mass Function A:
- m({A}) = (0.8 * 0.8) + (0.6 * 0.5) = 0.64 + 0.30 = 0.94
- m({θ}) = 1 - 0.94 = 0.06
```

### Untuk Penyakit B:
```
Rules: gejala_2 -> Penyakit B (keunikan: Tinggi)
       gejala_3 -> Penyakit B (keunikan: Sedang)

Mass Function B:
- m({B}) = (0.6 * 0.8) + (0.7 * 0.5) = 0.48 + 0.35 = 0.83
- m({θ}) = 1 - 0.83 = 0.17
```

## 3. Kombinasi Evidence

### Langkah 1: Kombinasi Mass Function A dan B
```
m1 = {A: 0.94, θ: 0.06}
m2 = {B: 0.83, θ: 0.17}

Konflik (K) = m1(θ) * m2(θ) = 0.06 * 0.17 = 0.0102

Normalisasi Factor = 1 - K = 1 - 0.0102 = 0.9898

Hasil Kombinasi:
- m12({A}) = (m1(A) * m2(θ) + m1(θ) * m2(A)) / (1-K)
          = (0.94 * 0.17 + 0.06 * 0.83) / 0.9898
          = (0.1598 + 0.0498) / 0.9898
          = 0.2096 / 0.9898
          = 0.2117

- m12({B}) = (m1(θ) * m2(B) + m1(B) * m2(θ)) / (1-K)
          = (0.06 * 0.83 + 0.94 * 0.17) / 0.9898
          = (0.0498 + 0.1598) / 0.9898
          = 0.2096 / 0.9898
          = 0.2117

- m12({θ}) = (m1(θ) * m2(θ)) / (1-K)
          = (0.06 * 0.17) / 0.9898
          = 0.0102 / 0.9898
          = 0.0103
```

## 4. Hasil Akhir

### Belief untuk Setiap Penyakit:
```
Penyakit A: 0.2117 (21.17%)
Penyakit B: 0.2117 (21.17%)
Ketidaktahuan (θ): 0.0103 (1.03%)
```

### Diagnosis Utama:
```
Kedua penyakit memiliki belief yang sama (0.2117)
Sistem akan memilih berdasarkan kriteria tambahan atau
menampilkan kedua kemungkinan diagnosis
```

## 5. Validasi Hasil

### Cek Konflik:
```
Konflik Total: 0.0102 (1.02%)
Status: Rendah (OK)
```

### Cek Belief:
```
Belief Tertinggi: 0.2117
Status: Sedang (Perlu pertimbangan lebih lanjut)
```

## 6. Alur Lengkap dalam Kode

```php
// 1. Input densitas results
$densitasResults = [
    1 => ['densitas' => 0.8],
    2 => ['densitas' => 0.6], 
    3 => ['densitas' => 0.7]
];

// 2. Hitung mass function untuk setiap penyakit
$massFunctions = [];
foreach ($penyakitIds as $penyakitId) {
    $massFunctions[$penyakitId] = $service->calculateMassFunction($penyakitId, $densitasResults);
}

// 3. Kombinasi semua evidence
$combinedMass = $service->combineAllEvidence($massFunctions);

// 4. Hitung belief final
$penyakitBeliefs = [];
foreach ($penyakitIds as $penyakitId) {
    $penyakitBeliefs[$penyakitId] = $combinedMass[$penyakitId] ?? 0;
}

// 5. Validasi hasil
$validation = $service->validateCombinationResults([
    'penyakit_beliefs' => $penyakitBeliefs,
    'total_conflict' => $service->calculateTotalConflictAccurate($massFunctions)
]);
```

## 7. Keunggulan Metode Baru

### vs Metode Lama:
```
Metode Lama:
- Rata-rata sederhana: (densitas * keunikan) / count
- Tidak ada perhitungan konflik
- Tidak ada normalisasi proper

Metode Baru:
- Teori Dempster-Shafer yang benar
- Perhitungan konflik (K)
- Normalisasi dengan (1-K)
- Mass function yang proper
- Validasi hasil
```

### Contoh Perbandingan:
```
Gejala: [0.8, 0.6, 0.7]

Metode Lama:
Penyakit A: (0.8*0.8 + 0.6*0.5) / 2 = 0.47
Penyakit B: (0.6*0.8 + 0.7*0.5) / 2 = 0.415

Metode Baru:
Penyakit A: 0.2117 (setelah normalisasi)
Penyakit B: 0.2117 (setelah normalisasi)
Konflik: 0.0102
```

## 8. Monitoring dan Debugging

### Debug Process:
```php
$debugInfo = $service->debugCombinationProcess($densitasResults);

// Lihat mass function awal
foreach ($debugInfo['mass_functions'] as $penyakitId => $info) {
    echo "Penyakit: {$info['penyakit_nama']}";
    echo "Mass Function: " . json_encode($info['mass_function']);
}

// Lihat langkah kombinasi
foreach ($debugInfo['combination_steps'] as $step => $info) {
    echo "Step {$step}: {$info['description']}";
    echo "Result: " . json_encode($info['result_mass']);
}
```

### Perbandingan Metode:
```php
$comparison = $service->compareMethods($densitasResults);

echo "Perbedaan Belief:";
foreach ($comparison['differences'] as $penyakitId => $diff) {
    echo "Penyakit {$penyakitId}: {$diff['percentage_change']}%";
}

echo "Perbaikan:";
foreach ($comparison['improvements'] as $improvement) {
    echo "- {$improvement}";
}
```
