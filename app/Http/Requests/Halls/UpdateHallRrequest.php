<?php

namespace App\Http\Requests\Halls;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHallRrequest extends FormRequest
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
            'hall_name' => 'string',
            'capacity' => 'integer',
            'has_monitor' => 'bool',
            'has_projector' => 'bool',
            'has_air_condition' => 'bool',
            'is_special' => 'bool',
            'type' => 'string',
            'status' => 'string',
            'description_place' => 'string',
            'floor_place' => 'integer',
            'building_place' => 'integer',
        ];
    }
}
