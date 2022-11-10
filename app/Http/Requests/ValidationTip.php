<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Helper;

class ValidationTip extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
        'date' => Helper::formatDateDatabase($this->date)
        ]);
    }
}
