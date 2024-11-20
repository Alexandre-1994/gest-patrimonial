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
        'from_user_id',
        'to_user_id',
        'from_location',
        'to_location',
        'reason',
        'movement_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'movement_date' => 'datetime'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
