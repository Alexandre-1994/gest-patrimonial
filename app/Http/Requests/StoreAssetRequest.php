<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:asset_categories,id',
            'location' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:assets',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'purchase_value' => 'required|numeric',
            'purchase_date' => 'required|date',
            'current_value' => 'required|numeric',
            'depreciation_rate' => 'required|numeric',
            'cost_center_id' => 'required|exists:cost_centers,id',
            'technical_specifications' => 'nullable|string',
            'conservation_status' => 'required|in:excellent,good,regular,poor',
            'life_span_months' => 'required|integer',
            'warranty_start' => 'nullable|date',
            'warranty_end' => 'nullable|date|after:warranty_start',
            'status' => 'required|in:active,inactive,maintenance,disposed',
            'responsible_user_id' => 'required|exists:users,id',
            'criticality_level' => 'required|in:low,medium,high,critical',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx',
            'photos.*' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:asset_tags,id'
        ];
    }
}
