<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchBillsRequest extends FormRequest
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
            'searchDate' => 'required|date_format:Y-m-d',
        ];
    }
    public function messages()
    {
        return [
            'searchDate.required' => 'Search date is required',
            'searchDate.date_format' => 'Invalid date format. Expected YYYY-MM-DD',
        ];
    }
}
