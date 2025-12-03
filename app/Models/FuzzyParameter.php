<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuzzyParameter extends Model
{
    protected $table = 'fuzzy_parameters';

    protected $fillable = [
        'tipe',
        'label',
        'nilai',
        'deskripsi',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
        'is_active' => 'boolean',
        'urutan' => 'integer'
    ];

    // Scope untuk parameter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk tipe tertentu
    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // Get all kemunculan parameters
    public static function getKemunculanOptions()
    {
        return static::active()
            ->byTipe('kemunculan')
            ->orderBy('urutan')
            ->get();
    }

    // Get all keunikan parameters
    public static function getKeunikanOptions()
    {
        return static::active()
            ->byTipe('keunikan')
            ->orderBy('urutan')
            ->get();
    }

    // Get nilai by label and tipe
    public static function getNilaiByLabel($tipe, $label)
    {
        $param = static::active()
            ->byTipe($tipe)
            ->where('label', $label)
            ->first();

        return $param ? $param->nilai : 0.5; // Default value
    }

    // Get color for kemunculan badge (dynamic based on urutan)
    public static function getKemunculanColor($label)
    {
        $param = static::active()
            ->byTipe('kemunculan')
            ->where('label', $label)
            ->first();

        if (!$param) {
            return '#9e9e9e'; // Default gray
        }

        // Generate color based on urutan or nilai
        $colors = ['#ff5722', '#ff9800', '#ffc107', '#4caf50', '#2196f3'];
        $index = $param->urutan % count($colors);
        return $colors[$index];
    }

    // Get color for keunikan badge (dynamic based on urutan)
    public static function getKeunikanColor($label)
    {
        $param = static::active()
            ->byTipe('keunikan')
            ->where('label', $label)
            ->first();

        if (!$param) {
            return '#9e9e9e'; // Default gray
        }

        // Generate color based on urutan or nilai
        $colors = ['#03a9f4', '#ff9800', '#f44336'];
        $index = $param->urutan % count($colors);
        return $colors[$index];
    }

    // Get label by nilai and tipe (reverse lookup)
    public static function getLabelByNilai($tipe, $nilai)
    {
        $params = static::active()
            ->byTipe($tipe)
            ->orderBy('urutan')
            ->get();

        $closestParam = null;
        $minDifference = PHP_FLOAT_MAX;

        foreach ($params as $param) {
            $difference = abs($param->nilai - $nilai);
            if ($difference < $minDifference) {
                $minDifference = $difference;
                $closestParam = $param;
            }
        }

        return $closestParam ? $closestParam->label : 'Sedang';
    }
}
