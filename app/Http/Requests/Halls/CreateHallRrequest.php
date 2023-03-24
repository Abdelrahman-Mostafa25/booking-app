<?php

namespace App\Http\Requests\Halls;

use Illuminate\Foundation\Http\FormRequest;

class CreateHallRrequest extends FormRequest
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
            'hall_name' => 'required|string',
            'capacity' => 'required|integer',
            'has_monitor' => 'required|bool',
            'has_projector' => 'required|bool',
            'has_air_condition' => 'required|bool',
            'is_special' => 'required|bool',
            'type' => 'required|string',
            'status' => 'required|string',
            'description_place' => 'required|string',
            'floor_place' => 'required|integer',
            'building_place' => 'required|integer',
        ];
    }
}
