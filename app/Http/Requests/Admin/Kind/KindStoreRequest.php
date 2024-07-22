<?php

namespace App\Http\Requests\Admin\Kind;

use Illuminate\Foundation\Http\FormRequest;

class KindStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'key' => 'required|unique:kinds,key',
            'value_1' => 'required',
            'value_2' => 'nullable',
            'parent_id' => 'nullable',
            'is_active' => 'nullable'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return __('models.kind');
    }
}
