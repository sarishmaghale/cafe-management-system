<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslationRequest extends FormRequest
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
            'text' => 'required|string',
            'to' => 'required|string',
            'from' => 'nullable|string'
        ];
    }
    public function validatedData()
    {
        return [
            'text' => $this->text,
            'to' => $this->to,
            'from' => $this->from ?? 'auto',
        ];
    }
}
