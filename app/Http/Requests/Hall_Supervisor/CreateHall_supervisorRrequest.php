<?php

namespace App\Http\Requests\Hall_Supervisor;

use Illuminate\Foundation\Http\FormRequest;

class CreateHall_supervisorRrequest extends FormRequest
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
            'hall_num_id' => 'required|integer',
            'supervisor_name' => 'required|string',
        ];
    }
}
