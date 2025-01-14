<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_id',
        'active',
        'depreciation_rate',
        'estimated_life_months'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(AssetCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AssetCategory::class, 'parent_id');
    }
}
