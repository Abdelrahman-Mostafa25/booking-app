<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\CreateBookRrequest;
use App\Http\Requests\Booking\UpdateBookIdRrequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookRrequest $request)
    {
        $data = $request->all();
        $concatenatedData = $request->get('hall_num_id') . '-' . $request->get('start_time_booking') . '-' . $request->get('end_time_booking') . '-' . $request->get('booking_day'). '-' . $request->get('type');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:bookings,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an employee that booked the same hall in the same time.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        DB::table('bookings')->insert([
            'employee_num_id' => $request->get('employee_num_id'),
            'hall_num_id' => $request->get('hall_num_id'),
            'start_time_booking' => $request->get('start_time_booking'),
            'end_time_booking' => $request->get('end_time_booking'),
            'booking_day' => $request->get('booking_day'),
            'type' => $request->get('type'),
            'concatenated_data' => $concatenatedData,
        ]);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $employee_num_id
     *  @param  int  $hall_num_id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_num_id, $hall_num_id)
    {
        if (filled($employee_num_id) && filled($hall_num_id) && is_numeric($employee_num_id) && is_numeric($hall_num_id)) {
            $bookings = Booking::where('employee_num_id', $employee_num_id)
                ->where('hall_num_id', $hall_num_id)
                ->get();
            return response()->json($bookings);
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $employee_num_id
     *  @param  int  $hall_num_id
     *  @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookIdRrequest $request, $id, $employee_num_id, $hall_num_id)
    {
        if (filled($id) && filled($employee_num_id) && filled($hall_num_id) && is_numeric($employee_num_id) && is_numeric($hall_num_id) && is_numeric($id)) {
            $booking = DB::table('bookings')
                ->where('id', $id)
                ->where('employee_num_id', $employee_num_id)
                ->where('hall_num_id', $hall_num_id)
                ->get();
            if ($booking->isNotEmpty()) {
                $bookings = DB::table('bookings')
                    ->where('id', $id)
                    ->where('employee_num_id', $employee_num_id)
                    ->where('hall_num_id', $hall_num_id)
                    ->update($request->all());

                $updatedBooking = DB::table('bookings')
                    ->where('id', $id)
                    ->where('employee_num_id', $employee_num_id)
                    ->where('hall_num_id', $hall_num_id)
                    ->first();

                $concatenatedData = $updatedBooking->hall_num_id
                    . '-' . date_format(date_create($updatedBooking->start_time_booking), 'H:i')
                    . '-' . date_format(date_create($updatedBooking->end_time_booking), 'H:i')
                    . '-' . $updatedBooking->booking_day;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $bookings = DB::table('bookings')
                    ->where('id', $id)
                    ->where('employee_num_id', $employee_num_id)
                    ->where('hall_num_id', $hall_num_id)
                    ->update(['concatenated_data' => $concatenatedData]);

                return response()->json($bookings);
            } else {
                return "Not Found";
            }
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $employee_num_id
     * * @param  int  $hall_num_id
     *  @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $employee_num_id, $hall_num_id)
    {
        if (filled($id) && filled($employee_num_id) && filled($hall_num_id) && is_numeric($employee_num_id) && is_numeric($hall_num_id) && is_numeric($id)) {
            $booking = DB::table('bookings')
                ->where('id', $id)
                ->where('employee_num_id', $employee_num_id)
                ->where('hall_num_id', $hall_num_id)
                ->get();
            if ($booking->isNotEmpty()) {
                $booking = DB::table('bookings')
                    ->where('id', $id)
                    ->where('employee_num_id', $employee_num_id)
                    ->where('hall_num_id', $hall_num_id);
                $booking->delete();
                return response('', 204);
            } else {
                return "Not Found";
            }
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }
}
