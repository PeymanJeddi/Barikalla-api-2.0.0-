<?php

namespace App\Http\Requests\Api\User\Link;

use Illuminate\Foundation\Http\FormRequest;

class LinkUpdateRequest extends FormRequest
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
            'links' => 'required|array',
            'links.*.link_id' => 'required|exists:kinds,id',
            'links.*.value' => 'required',
        ];
    }
}
