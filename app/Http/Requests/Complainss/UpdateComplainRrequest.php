<?php

namespace App\Http\Requests\Complainss;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplainRrequest extends FormRequest
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
            'employee_num_id' => 'integer',
            'hall_num' => 'integer',
            'text_complain' => 'string',
        ];
    }
}
