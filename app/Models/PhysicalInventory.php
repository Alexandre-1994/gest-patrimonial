<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PhysicalInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_date',
        'notes',
    ];

    protected $dates = [
        'inventory_date',
    ];
    // Método adicional para garantir que a data seja formatada corretamente
    public function getInventoryDateAttribute($value)
    {
        return Carbon::parse($value);
    }
}
