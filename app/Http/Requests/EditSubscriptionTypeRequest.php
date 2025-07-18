<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditSubscriptionTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('web')->user() !== null && auth('web')->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => 'min:3|max:255',
            'price' => 'numeric',
        ];
    }
}
