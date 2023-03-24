<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRrequest extends FormRequest
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
            'employee_num_id' => 'required|integer',
            'hall_num_id' => 'required|integer',
            'start_time_booking' => 'required|date_format:H:i',
            'end_time_booking' =>  'required|date_format:H:i|after:start_time_booking',
            'booking_day' => 'required|date_format:Y-m-d',
        ];
    }
}
