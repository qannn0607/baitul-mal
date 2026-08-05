<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MustahikApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_name',
        'nik',
        'phone',
        'address',
        'asnaf_category',
        'program_type',
        'amount_requested',
        'reason',
        'sktm_proof_image',
        'status',
        'rejection_reason',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'amount_requested' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
