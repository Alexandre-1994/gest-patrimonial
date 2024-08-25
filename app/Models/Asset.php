<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'serial_number',
        'acquisition_date',
        'acquisition_value',
        'useful_life',
        'location',
        'category',
        'supplier',
        'state',
        'user_id',
        'is_scrapped',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'acquisition_date' => 'date',
        'acquisition_value' => 'decimal:2',
    ];
}
