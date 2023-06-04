<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRrequest extends FormRequest
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
            'code' => 'required|string|unique:courses,code',
            'hall_num_id' => 'integer',
            'course_name' => 'required|string',
            'program' => 'required|string',
            'practic' => 'required|string',
            'is_special' => 'required|bool',
            'credit_hours' => 'required|integer|min:1',
            'semester' => 'required|string',
            'level' => 'required|integer|min:1',
        ];
    }
}
