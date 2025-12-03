# Contoh Penggunaan DempsterShaferService yang Diperbarui

## Implementasi Teori Dempster-Shafer yang Akurat

Service ini telah diperbarui dengan implementasi teori Dempster-Shafer yang benar sesuai dengan ketentuan yang diminta.

### Fungsi Utama yang Baru

#### 1. `combineEvidenceAccurate($densitasResults)`
Fungsi utama untuk kombinasi evidence menggunakan teori Dempster-Shafer yang akurat.

```php
use App\Services\DempsterShaferService;

$service = new DempsterShaferService();

// Data densitas dari fuzzy logic
$densitasResults = [
    1 => ['densitas' => 0.8],  // Gejala 1 dengan densitas 0.8
    2 => ['densitas' => 0.6],  // Gejala 2 dengan densitas 0.6
    3 => ['densitas' => 0.7]   // Gejala 3 dengan densitas 0.7
];

// Kombinasi evidence
$result = $service->combineEvidenceAccurate($densitasResults);

// Hasil
echo "Belief untuk penyakit: " . json_encode($result['penyakit_beliefs']);
echo "Konflik total: " . $result['total_conflict'];
echo "Mass function: " . json_encode($result['combined_mass']);
```

#### 2. `getDetailedResults($densitasResults)`
Mendapatkan hasil detail dengan informasi penyakit lengkap.

```php
$detailedResults = $service->getDetailedResults($densitasResults);

foreach ($detailedResults['penyakit_details'] as $penyakit) {
    echo "Penyakit: {$penyakit['nama']} (Kode: {$penyakit['kode']})";
    echo "Belief: {$penyakit['belief']}";
    echo "Mass Value: {$penyakit['mass_value']}";
    echo "---";
}

echo "Diagnosis Utama: " . $detailedResults['diagnosis_utama']['nama'];
echo "Konflik Total: " . $detailedResults['total_conflict'];
```

#### 3. `validateCombinationResults($results)`
Validasi hasil kombinasi untuk memastikan kualitas diagnosis.

```php
$results = $service->combineEvidenceAccurate($densitasResults);
$validation = $service->validateCombinationResults($results);

if (!$validation['is_valid']) {
    echo "Error: " . implode(', ', $validation['errors']);
}

if (!empty($validation['warnings'])) {
    echo "Warning: " . implode(', ', $validation['warnings']);
}
```

#### 4. `debugCombinationProcess($densitasResults)`
Debug proses kombinasi untuk analisis detail.

```php
$debugInfo = $service->debugCombinationProcess($densitasResults);

// Lihat mass function untuk setiap penyakit
foreach ($debugInfo['mass_functions'] as $penyakitId => $info) {
    echo "Penyakit: {$info['penyakit_nama']}";
    echo "Mass Function: " . json_encode($info['mass_function']);
}

// Lihat langkah-langkah kombinasi
foreach ($debugInfo['combination_steps'] as $step => $info) {
    echo "Step {$step}: {$info['description']}";
    echo "Result: " . json_encode($info['result_mass']);
}
```

#### 5. `compareMethods($densitasResults)`
Membandingkan metode lama vs baru.

```php
$comparison = $service->compareMethods($densitasResults);

echo "Metode Lama: " . json_encode($comparison['old_method']);
echo "Metode Baru: " . json_encode($comparison['new_method']);

foreach ($comparison['differences'] as $penyakitId => $diff) {
    echo "Penyakit {$penyakitId}:";
    echo "  Lama: {$diff['old_belief']}";
    echo "  Baru: {$diff['new_belief']}";
    echo "  Perbedaan: {$diff['difference']}";
    echo "  Persentase: {$diff['percentage_change']}%";
}

foreach ($comparison['improvements'] as $improvement) {
    echo "Perbaikan: {$improvement}";
}
```

## Implementasi Teori Dempster-Shafer

### 1. Mass Function untuk Setiap Gejala
```php
// Untuk setiap gejala yang dipilih:
// m({A}) = densitas * keunikan
// m({θ}) = 1 - densitas (θ = ketidaktahuan)
// m({A,B}) = 0 (tidak ada kombinasi penyakit dalam satu evidence)
```

### 2. Kombinasi Evidence
```php
// Rumus Dempster-Shafer:
// m12(A) = (Σ m1(X) * m2(Y)) / (1 - K)
// dimana K = Σ m1(X) * m2(Y) untuk X∩Y = ∅ (konflik)
```

### 3. Perhitungan Konflik
```php
// Konflik terjadi ketika ada intersection yang kosong
// K = Σ m1(X) * m2(Y) untuk X∩Y = ∅
```

### 4. Normalisasi
```php
// Hasil kombinasi dinormalisasi dengan (1 - K)
// Jika K = 1, maka terjadi konflik total
```

## Keunggulan Implementasi Baru

1. **Akurat sesuai teori**: Menggunakan rumus Dempster-Shafer yang benar
2. **Perhitungan konflik**: Mendeteksi dan menghitung konflik dalam sistem
3. **Normalisasi proper**: Hasil dinormalisasi dengan benar
4. **Debugging tools**: Tools untuk analisis proses kombinasi
5. **Validasi hasil**: Validasi kualitas hasil diagnosis
6. **Perbandingan metode**: Membandingkan dengan metode lama

## Penggunaan dalam Controller

```php
// Di controller diagnosis
public function processDiagnosis($densitasResults)
{
    $dsService = new DempsterShaferService();
    
    // Gunakan metode baru
    $results = $dsService->combineEvidenceAccurate($densitasResults);
    
    // Validasi hasil
    $validation = $dsService->validateCombinationResults($results);
    
    if (!$validation['is_valid']) {
        return response()->json(['error' => 'Hasil diagnosis tidak valid'], 400);
    }
    
    // Ambil diagnosis utama
    $diagnosisUtama = $dsService->getDetailedResults($densitasResults)['diagnosis_utama'];
    
    return response()->json([
        'diagnosis' => $diagnosisUtama,
        'all_results' => $results,
        'warnings' => $validation['warnings']
    ]);
}
```

## Catatan Penting

1. **Backward Compatibility**: Fungsi lama `combineEvidence()` masih tersedia
2. **Performance**: Metode baru lebih akurat tapi mungkin sedikit lebih lambat
3. **Debugging**: Gunakan `debugCombinationProcess()` untuk analisis detail
4. **Validasi**: Selalu validasi hasil dengan `validateCombinationResults()`
5. **Konflik**: Monitor nilai konflik untuk memastikan kualitas diagnosis
