<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AssetMovement extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'old_location',
        'new_location',
        'moved_at',
        'notes',
    ];
    protected $casts = [
        'moved_at' => 'datetime',
    ];
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
