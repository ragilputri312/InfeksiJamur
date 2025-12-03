<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DsRule extends Model
{
    protected $table = 'ds_rules';

    protected $fillable = [
        'penyakit_id',
        'gejala_id',
        'fuzzy_parameter_id',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id', 'id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id', 'id');
    }

    public function fuzzyParameter(): BelongsTo
    {
        return $this->belongsTo(FuzzyParameter::class, 'fuzzy_parameter_id', 'id');
    }

    // Accessor untuk backward compatibility
    public function getKeunikanAttribute()
    {
        return $this->fuzzyParameter ? $this->fuzzyParameter->label : null;
    }
}
