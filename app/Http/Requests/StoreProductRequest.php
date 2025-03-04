<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Add authorization logic if needed (e.g., check if user is admin)
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:simple,configurable',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }
}