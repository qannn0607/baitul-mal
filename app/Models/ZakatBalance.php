<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZakatBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_collected',
        'total_distributed',
        'current_balance',
    ];

    protected $casts = [
        'total_collected' => 'decimal:2',
        'total_distributed' => 'decimal:2',
        'current_balance' => 'decimal:2',
    ];

    /**
     * Get Singleton Row
     */
    public static function getInstance(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'total_collected' => 0,
                'total_distributed' => 0,
                'current_balance' => 0,
            ]
        );
    }
}
