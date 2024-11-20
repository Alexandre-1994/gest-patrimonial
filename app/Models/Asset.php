<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'category_id',
        'location',
        'serial_number',
        'brand',
        'model',
        'purchase_value',
        'purchase_date',
        'current_value',
        'depreciation_rate',
        'maintenance_cost_total',
        'cost_center_id',
        'technical_specifications',
        'conservation_status',
        'life_span_months',
        'warranty_start',
        'warranty_end',
        'status',
        'responsible_user_id',
        'criticality_level'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        // 'acquisition_date' => 'date',
        // 'acquisition_value' => 'decimal:2',
        'purchase_date' => 'date',
        'warranty_start' => 'date',
        'warranty_end' => 'date',
        'purchase_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'depreciation_rate' => 'decimal:2',
    ];

    // Relacionamentos
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class);
    }

    public function documents()
    {
        return $this->hasMany(AssetDocument::class);
    }

    public function movements()
    {
        return $this->hasMany(AssetMovement::class);
    }

    public function photos()
    {
        return $this->hasMany(AssetPhoto::class);
    }

    public function tags()
    {
        return $this->belongsToMany(AssetTag::class, 'asset_tag', 'asset_id', 'tag_id');
    }

    public function relatedAssets()
    {
        return $this->belongsToMany(Asset::class, 'related_assets', 'asset_id', 'related_asset_id')
            ->withPivot('relationship_type', 'description');
    }

    // Métodos úteis
    public function calculateDepreciation()
    {
        $age = $this->purchase_date->diffInMonths(now());
        $depreciation = $this->purchase_value * ($this->depreciation_rate / 100 * $age / 12);
        $this->current_value = max($this->purchase_value - $depreciation, 0);
        $this->save();
    }

    public function updateMaintenanceCosts()
    {
        $this->maintenance_cost_total = $this->maintenances()->sum('cost');
        $this->save();
    }

    public function isUnderWarranty()
    {
        return $this->warranty_end && $this->warranty_end->isFuture();
    }

    public function getNextScheduledMaintenance()
    {
        return $this->maintenances()
            ->where('scheduled_date', '>', now())
            ->orderBy('scheduled_date')
            ->first();
    }
}
