<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class TaskRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:1',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH']))
            $rules['status'] = ['required', function ($attribute, $value, $fail) {
                if (!in_array($value, Task::STATUSES))
                    $fail("Status is Invalid");
            }];

        return $rules;
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors(),'status' =>422], 422));
    }
}
