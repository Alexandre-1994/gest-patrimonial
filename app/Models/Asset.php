<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'cost_center_id',
        'location',
        'serial_number',
        'brand',
        'model',
        'purchase_value',
        'purchase_date',
        'current_value',
        'depreciation_rate',
        'maintenance_cost_total',
        'technical_specifications',
        'conservation_status',
        'life_span_months',
        'warranty_start',
        'warranty_end',
        'status',
        'responsible_user_id',
        'criticality_level'
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function movements()
    {
        return $this->hasMany(AssetMovement::class);
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class);
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class);
    }

    public function inventories()
    {
        return $this->belongsToMany(PhysicalInventory::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }
}
