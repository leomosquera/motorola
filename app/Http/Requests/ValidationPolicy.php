<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Helper;

class ValidationPolicy extends FormRequest
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
            'usuario_id'     => 'required|integer',
            'policy_type_id' => 'required|integer',
            'name'           => 'required|string|max:100',
            'nro'            => 'required|string|max:100',
            'patent'         => 'required|string|max:100',
            'price_premium'  => 'required|between:0,9999999.99',
            'price_award'    => 'required|between:0,9999999.99',
            'date_start'     => 'required|date',
            'date_end'       => 'required|date'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date_start' => Helper::formatDateDatabase($this->date_start),
            'date_end'   => Helper::formatDateDatabase($this->date_end),
            'price_premium' => (float) str_replace(',', '', $this->price_premium),
            'price_award'    => (float) str_replace(',', '', $this->price_award)
        ]);
    }
}
