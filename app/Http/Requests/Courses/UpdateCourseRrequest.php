<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRrequest extends FormRequest
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
            'code' => 'string|exists:courses,code',
            'hall_num_id' => 'integer',
            'course_name' => 'string',
            'practic' => 'string',
            'is_special' => 'bool',
            'credit_hours' => 'integer|min:1',
            'semester' => 'string',
            'level' => 'integer|min:1',
        ];
    }
}
