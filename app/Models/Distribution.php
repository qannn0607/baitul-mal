<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'asnaf',
        'recipient_name',
        'amount',
        'distribution_date',
        'notes',
        'distributed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    public function amil(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }
}
