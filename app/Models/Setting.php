<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'qris_image',
        'nisab_gold_price',
        'zakat_fitrah_nominal',
    ];

    protected function casts(): array
    {
        return [
            'nisab_gold_price' => 'integer',
            'zakat_fitrah_nominal' => 'integer',
        ];
    }

    public static function getQrisUrl(): string
    {
        $setting = static::first();
        if ($setting && $setting->qris_image) {
            return asset('storage/' . $setting->qris_image);
        }
        return asset('images/qris-sample.png');
    }
}
