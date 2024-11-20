<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'type',
        'scheduled_date',
        'execution_date',
        'description',
        'cost',
        'service_provider',
        'status'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'execution_date' => 'date',
        'cost' => 'decimal:2'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
