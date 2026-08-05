<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_name',
        'title',
        'amount',
        'proof_image',
        'snap_token',
        'midtrans_order_id',
        'status',
        'rejection_reason',
        'verified_by',
        'verified_at',
        'distributed_at',
        'notes',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'distributed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
