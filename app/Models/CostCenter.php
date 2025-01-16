<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'manager_id',
        'annual_budget',
        'current_budget',
        'status',
        'valid_from'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($costCenter) {
            if (!isset($costCenter->valid_from)) {
                $costCenter->valid_from = now();
            }
        });
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
