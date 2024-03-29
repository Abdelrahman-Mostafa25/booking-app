<?php

namespace App\Http\Requests\Teach;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeachRrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_code' => 'required|string',
            'employee_num_id' => 'required|integer',
        ];
    }
}
