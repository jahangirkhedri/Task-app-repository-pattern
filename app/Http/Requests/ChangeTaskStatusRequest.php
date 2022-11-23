<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeTaskStatusRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => ['required', function ($attribute, $value, $fail) {
                if (!in_array($value, Task::STATUSES))
                    $fail("This status is invalid");
            }]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(), 'status' => 422], 422));
    }
}
