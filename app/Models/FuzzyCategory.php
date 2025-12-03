<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuzzyCategory extends Model
{
    protected $table = 'fuzzy_categories';

    protected $fillable = [
        'nama_kategori',
        'min_value',
        'max_value',
        'label',
        'color',
        'is_active'
    ];

    protected $casts = [
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Method untuk mendapatkan kategori berdasarkan nilai belief
    public static function getCategoryByBelief($belief)
    {
        return static::active()
            ->where('min_value', '<=', $belief)
            ->where('max_value', '>=', $belief)
            ->first();
    }
}
