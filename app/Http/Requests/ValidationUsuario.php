<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationUsuario extends FormRequest
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
            'username'              => 'required|max:20|unique:usuarios,username,' . $this->route('id'),
            'email'                 => 'required|email|max:100|unique:usuarios,username,' . $this->route('id'),
            'password'              => ($this->password_change_confirm == 1 ? 'required|' : '') . 'same:password_confirmation',
            'password_confirmation' => ($this->password_change_confirm == 1 ? 'required|' : '') . 'same:password',
            'password_changed'      => 'integer|between:0,1',
            'name'                  => 'required|max:100',
            'lastname'              => 'required|max:100',
            'roles'                 => 'required',
            'image'                 => 'nullable|image|max:1024'
        ];
    }
}
