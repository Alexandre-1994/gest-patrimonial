<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'type',
        'title',
        'file_path',
        'expiration_date',
        'description'
    ];

    protected $casts = [
        'expiration_date' => 'date'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
