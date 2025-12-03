# Test Implementasi Dempster-Shafer yang Diperbaiki

## Masalah yang Diperbaiki

### ❌ Implementasi Lama (Salah)
```php
// Mass function per PENYAKIT (salah)
foreach ($penyakitIds as $penyakitId) {
    $massFunctions[$penyakitId] = $this->calculateMassFunction($penyakitId, $densitasResults);
}
```

### ✅ Implementasi Baru (Benar)
```php
// Mass function per GEJALA (benar)
foreach ($densitasResults as $gejalaId => $data) {
    $massFunctions[$gejalaId] = $this->calculateMassFunctionPerGejala($gejalaId, $data['densitas']);
}
```

## Contoh Test Case

### Scenario: Gejala yang Berhubungan dengan Multiple Penyakit

**Data Test:**
```php
$densitasResults = [
    1 => ['densitas' => 0.8],  // G001: Kelelahan ekstrem
    2 => ['densitas' => 0.6],  // G002: Nyeri dan bengkak pada sendi
    3 => ['densitas' => 0.7]    // G003: Ruam kulit
];
```

**Relasi Gejala-Penyakit (dari seeder):**
- G001 (Kelelahan ekstrem) → Lupus (Rendah), RA (Sedang), DM Tipe 1 (Rendah), Psoriasis (Rendah), Graves (Rendah)
- G002 (Nyeri sendi) → Lupus (Sedang), RA (Tinggi)
- G003 (Ruam kulit) → Lupus (Tinggi), Psoriasis (Sedang)

### Test dengan Metode Baru

```php
use App\Services\DempsterShaferService;

$service = new DempsterShaferService();

// Test kombinasi evidence
$results = $service->combineEvidenceAccurate($densitasResults);

echo "=== HASIL KOMBINASI EVIDENCE ===\n";
echo "Belief untuk setiap penyakit:\n";
foreach ($results['penyakit_beliefs'] as $penyakitId => $belief) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "- {$penyakit->penyakit}: {$belief}\n";
}

echo "\nKonflik Total: {$results['total_conflict']}\n";
```

### Debug Process

```php
// Debug proses kombinasi
$debugInfo = $service->debugCombinationProcess($densitasResults);

echo "=== MASS FUNCTION PER GEJALA ===\n";
foreach ($debugInfo['mass_functions'] as $gejalaId => $info) {
    echo "\nGejala: {$info['gejala_nama']} (Densitas: {$info['densitas']})\n";
    echo "Penyakit Terkait:\n";
    foreach ($info['penyakit_terkait'] as $penyakit) {
        echo "  - {$penyakit['nama']} (Keunikan: {$penyakit['keunikan']})\n";
    }
    echo "Mass Function: " . json_encode($info['mass_function'], JSON_PRETTY_PRINT) . "\n";
}

echo "\n=== LANGKAH KOMBINASI ===\n";
foreach ($debugInfo['combination_steps'] as $step => $info) {
    echo "\n{$step}: {$info['description']}\n";
    echo "Result: " . json_encode($info['result_mass'], JSON_PRETTY_PRINT) . "\n";
}
```

## Hasil yang Diharapkan

### Mass Function untuk G001 (Kelelahan ekstrem)
```json
{
    "penyakit": {
        "1,3,4,5,6": 0.32  // Kombinasi {Lupus, DM, Psoriasis, Graves, RA}
    },
    "theta": 0.68
}
```

### Mass Function untuk G002 (Nyeri sendi)
```json
{
    "penyakit": {
        "1,2": 0.45  // Kombinasi {Lupus, RA}
    },
    "theta": 0.55
}
```

### Mass Function untuk G003 (Ruam kulit)
```json
{
    "penyakit": {
        "1,4": 0.525  // Kombinasi {Lupus, Psoriasis}
    },
    "theta": 0.475
}
```

### Hasil Kombinasi Final
```
Lupus: 0.XXX (tertinggi karena muncul di 3 gejala)
RA: 0.XXX (muncul di 2 gejala)
Psoriasis: 0.XXX (muncul di 2 gejala)
DM Tipe 1: 0.XXX (muncul di 1 gejala)
Graves: 0.XXX (muncul di 1 gejala)
```

## Perbandingan Metode

```php
// Bandingkan metode lama vs baru
$comparison = $service->compareMethods($densitasResults);

echo "=== PERBANDINGAN METODE ===\n";
echo "Metode Lama:\n";
foreach ($comparison['old_method'] as $penyakitId => $belief) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "- {$penyakit->penyakit}: {$belief}\n";
}

echo "\nMetode Baru:\n";
foreach ($comparison['new_method']['penyakit_beliefs'] as $penyakitId => $belief) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "- {$penyakit->penyakit}: {$belief}\n";
}

echo "\nPerbedaan:\n";
foreach ($comparison['differences'] as $penyakitId => $diff) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "- {$penyakit->penyakit}: {$diff['percentage_change']}%\n";
}
```

## Validasi Hasil

```php
// Validasi hasil kombinasi
$validation = $service->validateCombinationResults($results);

echo "=== VALIDASI HASIL ===\n";
echo "Valid: " . ($validation['is_valid'] ? 'Ya' : 'Tidak') . "\n";

if (!empty($validation['warnings'])) {
    echo "Warning:\n";
    foreach ($validation['warnings'] as $warning) {
        echo "- {$warning}\n";
    }
}

if (!empty($validation['errors'])) {
    echo "Error:\n";
    foreach ($validation['errors'] as $error) {
        echo "- {$error}\n";
    }
}
```

## Keunggulan Implementasi Baru

### 1. **Teori yang Benar**
- ✅ Setiap gejala adalah satu evidence
- ✅ Satu gejala bisa mendukung multiple penyakit
- ✅ Mass function berbasis gejala, bukan penyakit

### 2. **Kombinasi yang Akurat**
- ✅ Menangani kombinasi penyakit yang kompleks
- ✅ Perhitungan konflik yang proper
- ✅ Normalisasi yang benar

### 3. **Debugging yang Lengkap**
- ✅ Mass function per gejala
- ✅ Langkah kombinasi step by step
- ✅ Informasi penyakit terkait

### 4. **Validasi Kualitas**
- ✅ Deteksi konflik tinggi
- ✅ Validasi belief yang masuk akal
- ✅ Warning untuk hasil yang tidak meyakinkan

## Contoh Output yang Diharapkan

```
=== HASIL KOMBINASI EVIDENCE ===
Belief untuk setiap penyakit:
- Lupus: 0.456
- Rheumatoid Arthritis: 0.234
- Psoriasis: 0.189
- DM Tipe 1: 0.123
- Graves Disease: 0.098

Konflik Total: 0.045

=== VALIDASI HASIL ===
Valid: Ya
Warning: 
- Belief tertinggi (0.456) cukup meyakinkan
- Konflik rendah (0.045) menunjukkan evidence yang konsisten
```

## Kesimpulan

Implementasi yang diperbaiki sekarang:

1. **Benar secara teori** - Mass function per gejala, bukan penyakit
2. **Menangani multiple penyakit** - Satu gejala bisa mendukung beberapa penyakit
3. **Kombinasi yang akurat** - Menggunakan rumus Dempster-Shafer yang benar
4. **Debugging yang lengkap** - Tools untuk analisis proses
5. **Validasi kualitas** - Monitoring konflik dan belief

Sistem sekarang dapat menangani kasus di mana satu gejala berhubungan dengan multiple penyakit, yang merupakan skenario yang sangat umum dalam diagnosis medis.
