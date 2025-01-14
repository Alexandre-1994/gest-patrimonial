<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_id',
        'type',
        'title',
        'file_path',
        'expiration_date',
        'description',
        'document_code'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
