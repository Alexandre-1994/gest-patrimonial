<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMaintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_id',
        'type',
        'scheduled_date',
        'execution_date',
        'description',
        'cost',
        'service_provider',
        'status',
        'priority',
        'title',
        'technical_details'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
