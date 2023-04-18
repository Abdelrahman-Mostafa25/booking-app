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
            'course_code' => 'required|string',
            'hall_num_id' => 'required|integer',
            'course_name' => 'required|string',
            'program' => 'required|string',
            'practic' => 'required|string',
            'is_special' => 'required|bool',
            'credit_hours' => 'required|integer',
            'semester' => 'required|integer',
            'level' => 'required|integer',
        ];
    }
}
