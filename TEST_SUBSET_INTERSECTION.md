# Test Subset Intersection dan Mass Proporsional

## Perbaikan yang Telah Dilakukan

### 1. ✅ Mass Proporsional Berdasarkan Keunikan

**❌ Implementasi Lama (Salah):**
```php
// Mass dibagi rata untuk semua penyakit
$combinedMass = $densitas * ($totalKeunikan / count($penyakitKeunikan));
$massFunction['penyakit'][$combinedKey] = $combinedMass;
```

**✅ Implementasi Baru (Benar):**
```php
// Mass proporsional berdasarkan keunikan
foreach ($penyakitKeunikan as $penyakitId => $keunikanValue) {
    $penyakitMass = $densitas * ($keunikanValue / $totalKeunikan);
    $massFunction['penyakit'][$penyakitId] = $penyakitMass;
}
```

### 2. ✅ Subset Intersection yang Lengkap

**❌ Implementasi Lama (Salah):**
```php
// Hanya menangani key yang identik
if (is_numeric($key)) {
    // Handle single penyakit
} elseif (strpos($key, ',') !== false) {
    // Handle multiple penyakit
}
```

**✅ Implementasi Baru (Benar):**
```php
// Menangani subset intersection
$intersection = $this->getIntersection($key1, $key2);
if (!empty($intersection)) {
    $combinationKey = $this->createCombinationKey($intersection);
    $combinations[$combinationKey] += ($value1 * $value2);
}
```

## Test Case: Subset Intersection

### Scenario 1: Gejala dengan Multiple Penyakit

**Input:**
```php
$densitasResults = [
    1 => ['densitas' => 0.8],  // G001: Kelelahan ekstrem
    2 => ['densitas' => 0.6],  // G002: Nyeri sendi
    3 => ['densitas' => 0.7]    // G003: Ruam kulit
];
```

**Relasi Gejala-Penyakit:**
- G001 → Lupus (0.3), RA (0.5), DM (0.3), Psoriasis (0.3), Graves (0.3)
- G002 → Lupus (0.5), RA (0.8)
- G003 → Lupus (0.8), Psoriasis (0.5)

### Expected Mass Functions

**G001 (Kelelahan ekstrem):**
```json
{
    "penyakit": {
        "1": 0.8 * (0.3/1.7) = 0.141,  // Lupus
        "2": 0.8 * (0.5/1.7) = 0.235,  // RA
        "3": 0.8 * (0.3/1.7) = 0.141,  // DM
        "4": 0.8 * (0.3/1.7) = 0.141,  // Psoriasis
        "5": 0.8 * (0.3/1.7) = 0.141   // Graves
    },
    "theta": 1.0 - 0.8 = 0.2
}
```

**G002 (Nyeri sendi):**
```json
{
    "penyakit": {
        "1": 0.6 * (0.5/1.3) = 0.231,  // Lupus
        "2": 0.6 * (0.8/1.3) = 0.369   // RA
    },
    "theta": 1.0 - 0.6 = 0.4
}
```

**G003 (Ruam kulit):**
```json
{
    "penyakit": {
        "1": 0.7 * (0.8/1.3) = 0.431,  // Lupus
        "4": 0.7 * (0.5/1.3) = 0.269   // Psoriasis
    },
    "theta": 1.0 - 0.7 = 0.3
}
```

### Expected Subset Intersections

**G001 ∩ G002:**
- {Lupus} = 0.141 * 0.231 = 0.033
- {RA} = 0.235 * 0.369 = 0.087
- {Lupus} + {RA} = 0.120

**G001 ∩ G003:**
- {Lupus} = 0.141 * 0.431 = 0.061
- {Psoriasis} = 0.141 * 0.269 = 0.038
- {Lupus} + {Psoriasis} = 0.099

**G002 ∩ G003:**
- {Lupus} = 0.231 * 0.431 = 0.100
- {Lupus} = 0.100

**G001 ∩ G002 ∩ G003:**
- {Lupus} = 0.141 * 0.231 * 0.431 = 0.014

## Test Code

```php
use App\Services\DempsterShaferService;

$service = new DempsterShaferService();

// Test kombinasi evidence
$results = $service->combineEvidenceAccurate($densitasResults);

echo "=== HASIL KOMBINASI EVIDENCE ===\n";
foreach ($results['penyakit_beliefs'] as $penyakitId => $belief) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "{$penyakit->penyakit}: {$belief}\n";
}

echo "\nKonflik Total: {$results['total_conflict']}\n";
```

### Debug Process

```php
// Debug proses kombinasi
$debugInfo = $service->debugCombinationProcess($densitasResults);

echo "=== MASS FUNCTION PER GEJALA ===\n";
foreach ($debugInfo['mass_functions'] as $gejalaId => $info) {
    echo "\nGejala: {$info['gejala_nama']}\n";
    echo "Densitas: {$info['densitas']}\n";
    echo "Mass Function:\n";
    foreach ($info['mass_function']['penyakit'] as $penyakitId => $mass) {
        $penyakit = \App\Models\Penyakit::find($penyakitId);
        echo "  {$penyakit->penyakit}: {$mass}\n";
    }
    echo "Theta: {$info['mass_function']['theta']}\n";
}

echo "\n=== LANGKAH KOMBINASI ===\n";
foreach ($debugInfo['combination_steps'] as $step => $info) {
    echo "\n{$step}: {$info['description']}\n";
    echo "Result:\n";
    foreach ($info['result_mass']['penyakit'] as $key => $mass) {
        if (is_numeric($key)) {
            $penyakit = \App\Models\Penyakit::find($key);
            echo "  {$penyakit->penyakit}: {$mass}\n";
        } else {
            $penyakitIds = explode(',', $key);
            $penyakitNames = [];
            foreach ($penyakitIds as $id) {
                $penyakit = \App\Models\Penyakit::find($id);
                $penyakitNames[] = $penyakit->penyakit;
            }
            echo "  {" . implode(', ', $penyakitNames) . "}: {$mass}\n";
        }
    }
    echo "Theta: {$info['result_mass']['theta']}\n";
}
```

## Expected Results

### Final Belief Values
```
Lupus: 0.XXX (tertinggi karena muncul di 3 gejala dengan intersection)
RA: 0.XXX (muncul di 2 gejala)
Psoriasis: 0.XXX (muncul di 2 gejala)
DM: 0.XXX (muncul di 1 gejala)
Graves: 0.XXX (muncul di 1 gejala)
```

### Key Improvements

1. **Mass Proporsional**: Setiap penyakit mendapat bobot sesuai keunikannya
2. **Subset Intersection**: Menangani intersection yang kompleks seperti {P1,P2} ∩ {P2,P3} = {P2}
3. **Konflik Akurat**: Perhitungan konflik yang benar untuk intersection kosong
4. **Normalisasi Proper**: Hasil yang dinormalisasi dengan benar

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

// Perbandingan dengan metode lama
$comparison = $service->compareMethods($densitasResults);

echo "\n=== PERBANDINGAN METODE ===\n";
echo "Perbedaan Belief:\n";
foreach ($comparison['differences'] as $penyakitId => $diff) {
    $penyakit = \App\Models\Penyakit::find($penyakitId);
    echo "{$penyakit->penyakit}: {$diff['percentage_change']}%\n";
}
```

## Kesimpulan

Implementasi yang diperbaiki sekarang:

1. **Mass Proporsional** - Setiap penyakit mendapat bobot sesuai keunikannya
2. **Subset Intersection** - Menangani intersection yang kompleks
3. **Konflik Akurat** - Perhitungan konflik yang benar
4. **Normalisasi Proper** - Hasil yang dinormalisasi dengan benar

Sistem sekarang dapat menangani kasus subset intersection yang kompleks dengan benar sesuai teori Dempster-Shafer.
