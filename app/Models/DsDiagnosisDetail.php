<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DsDiagnosisDetail extends Model
{
    protected $table = 'ds_diagnosis_details';

    protected $fillable = [
        'ds_diagnosis_id',
        'gejala_id',
        'kemunculan_fuzzy_parameter_id',
        'fuzzy_densitas',
        'mass_used_support',
        'mass_used_ignorance'
    ];

    protected $casts = [
        'fuzzy_densitas' => 'decimal:4',
        'mass_used_support' => 'decimal:3',
        'mass_used_ignorance' => 'decimal:3',
    ];

    protected $appends = [
        'kemunculan',
    ];

    public function dsDiagnosis(): BelongsTo
    {
        return $this->belongsTo(DsDiagnosis::class, 'ds_diagnosis_id', 'id');
    }

    public function gejala(): BelongsTo
    {
        return $this->belongsTo(Gejala::class, 'gejala_id', 'id');
    }

    public function kemunculanFuzzyParameter(): BelongsTo
    {
        return $this->belongsTo(FuzzyParameter::class, 'kemunculan_fuzzy_parameter_id', 'id');
    }

    // Accessor untuk backward compatibility
    public function getKemunculanAttribute()
    {
        return $this->kemunculanFuzzyParameter ? $this->kemunculanFuzzyParameter->label : null;
    }
}
