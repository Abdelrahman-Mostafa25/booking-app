<?php

namespace App\Http\Requests\Complainss;

use Illuminate\Foundation\Http\FormRequest;

class CreateComplainRrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_num_id' => 'required|integer',
            'hall_num' => 'required|integer',
            'text_complain' => 'required|string',
        ];
    }
}
