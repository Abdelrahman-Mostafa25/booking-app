<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRrequest extends FormRequest
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
            'employee_name' => 'required|string',
            'email' => 'required|string|unique:employees,email',
            'password' => 'required|string',
            'phone_num' => 'required|string',
            'specialization' => 'required|string',
            'employee_photo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }
}
