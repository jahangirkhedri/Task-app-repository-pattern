<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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

        $rules = [];
        if ($this->method() === 'POST') {
            $rules = [
                'name' => 'required|string|min:2',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed'
            ];
        } elseif(in_array($this->method(),['PATCH','PUT'])) {
            $rules = [
                'name' => 'required|string|min:2',
                'email' => 'required|email',
            ];
        }


        return $rules;

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(), 'status' => 422], 422));
    }
}
