<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DsDiagnosis extends Model
{
    protected $table = 'ds_diagnosis';

    protected $fillable = [
        'user_id',
        'penyakit_id',
        'belief_top',
        'severity_label',
        'conflict_k',
        'note'
    ];

    protected $casts = [
        'belief_top' => 'decimal:4',
        'conflict_k' => 'decimal:5',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TblAkun::class, 'user_id', 'id_akun');
    }

    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class, 'penyakit_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DsDiagnosisDetail::class, 'ds_diagnosis_id', 'id');
    }
}
