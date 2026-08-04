<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'qris_image',
        'nisab_gold_price',
        'zakat_fitrah_nominal',
        'announcement_banner',
        'bank_accounts',
        'org_name',
        'org_description',
        'contact_phone',
        'contact_email',
        'contact_address',
        'footer_text',
    ];

    protected $casts = [
        'bank_accounts' => 'array',
    ];

    public static function getQrisUrl(): string
    {
        $setting = static::first();
        if ($setting && $setting->qris_image) {
            return Storage::url($setting->qris_image);
        }
        return asset('qris_sample.png');
    }
}
