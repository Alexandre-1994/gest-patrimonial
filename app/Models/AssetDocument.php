<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document_code',
        'document_code',
        'asset_id',
        'type',
        'title',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'description',
        'document_date',
        'expiration_date',
        'reminder_date',
        'is_active',
        'requires_renewal',
        'is_confidential',
        'status',
        'version',
        'revision_number',
        'reference_number',
        'issuing_authority',
        'uploaded_by',
        'approved_by',
    ];

    protected $casts = [
        'document_date' => 'date',
        'expiration_date' => 'date',
        'reminder_date' => 'date',
        'validated_at' => 'datetime',
        'is_active' => 'boolean',
        'requires_renewal' => 'boolean',
        'is_confidential' => 'boolean'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
