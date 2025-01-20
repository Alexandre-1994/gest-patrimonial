<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMovement extends Model
{

    use SoftDeletes;
    protected $dates = [
        'movement_date',
        'created_at',
        'updated_at',
        'approved_at',
        'expected_delivery',
        'actual_delivery',
        'return_date'
    ];
    protected $fillable = [
        'asset_id',
        'from_user_id',
        'to_user_id',
        'from_location',
        'from_cost_center_id',
        'to_cost_center_id',
        'to_location',
        'reason',
        'movement_date',
        'status',
        'notes',

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

    public function fromCostCenter()
    {
        return $this->belongsTo(CostCenter::class, 'from_cost_center_id');
    }

    public function toCostCenter()
    {
        return $this->belongsTo(CostCenter::class, 'to_cost_center_id');
    }
}
