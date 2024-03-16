<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
//            'image' => 'nullable|image|max:1024',
            'name'              => 'required',
            'category_id'       => 'required',
            'unit_id'           => 'required',
            'is_active'         => 'required',
            'short_description' => 'nullable',
            'description'       => 'nullable',
            'image'             => 'image',
        ];
    }
}
