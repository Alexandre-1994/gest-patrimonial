<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalInventory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventory_date',
        'notes',
        'status',
        'start_date',
        'end_date',
        'total_items_expected',
        'total_items_counted'
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }
}
