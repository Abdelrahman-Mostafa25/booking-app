<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\CreateBookRrequest;
use App\Http\Requests\Booking\UpdateBookIdRrequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


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
        $concatenatedData = $request->get('hall_num_id') . '-' . $request->get('start_time_booking') . '-' . $request->get('end_time_booking') . '-' . $request->get('booking_day') . '-' . $request->get('type');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:bookings,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an employee that booked the same hall in the same time.'], 422);
        }

        $concatenatedData = str_replace(' ', '', $concatenatedData);
        $code = $request->filled('code') ? $request->get('code') : NULL;
        DB::table('bookings')->insert([
            'employee_num_id' => $request->get('employee_num_id'),
            'hall_num_id' => $request->get('hall_num_id'),
            'start_time_booking' => $request->get('start_time_booking'),
            'end_time_booking' => $request->get('end_time_booking'),
            'booking_day' => $request->get('booking_day'),
            'type' => $request->get('type'),
            'code' => $code,
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

    public function show_schedule($employee_num_id)
    {
        if (filled($employee_num_id) && is_numeric($employee_num_id)) {
            $bookings = Booking::where('employee_num_id', $employee_num_id)
                ->whereNotNull('code')
                ->get()->map(function ($booking) {
                    return [
                        'start_time' => date('g:i A', strtotime($booking->start_time_booking)),
                        'end_time' =>date('g:i A', strtotime($booking->end_time_booking)),
                        'booking_date' => $booking->booking_day,
                        'booking_day' => Carbon::parse($booking->booking_day)->format('l'),
                        'hall_name' => DB::table('halls')->where('hall_id', $booking->hall_num_id)->first()->hall_name,
                        'course_name' =>  DB::table('courses')->where('code', $booking->code)->first()->course_name
                    ];
                });
            return response()->json($bookings);
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }


    public function level_report($program, $level, $semester)
    {
        $validator = Validator::make([
            'program' => $program,
            'semester' => $semester,
            'level' => $level
        ], [
            'semester' => 'string',
            'program' => 'string',
            'level' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $courses_code = DB::table('courses')
            ->where('program', '=', $program)
            ->where('semester', '=', $semester)
            ->where('level', '=', $level)
            ->pluck('code')
            ->toArray();


        $booking_data = DB::table('bookings')
            ->whereIn('code', $courses_code)
            ->orderBy('booking_day', 'asc')
            ->orderBy('start_time_booking', 'asc')
            ->get()->map(function ($booking) {
                return [
                    'Doctor' => DB::table('employees')->where('employee_id', $booking->employee_num_id)->first()->employee_name,
                    'hall_name' => DB::table('halls')->where('hall_id', $booking->hall_num_id)->first()->hall_name,
                    'type_hall' => $booking->type,
                    'course_name' =>  DB::table('courses')->where('code', $booking->code)->first()->course_name,
                    'booking_day' => $booking->booking_day,
                    'start_time' => $booking->start_time_booking,
                    'end_time' => $booking->end_time_booking,
                ];
            });

        return $booking_data;
    }

    public function halls_report($hall_num_id)
    {
        $validator = Validator::make([
            'program' => $hall_num_id,
        ], [
            'hall_num_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }


        $booking_data = DB::table('bookings')
            ->where('hall_num_id','=' ,$hall_num_id)
            ->orderBy('booking_day', 'asc')
            ->orderBy('start_time_booking', 'asc')
            ->get()->map(function ($booking) {
                return [
                    'Doctor' => DB::table('employees')->where('employee_id', $booking->employee_num_id)->first()->employee_name,
                    'hall_name' => DB::table('halls')->where('hall_id', $booking->hall_num_id)->first()->hall_name,
                    'type_hall' => $booking->type,
                    'course_name' =>  DB::table('courses')->where('code', $booking->code)->first()->course_name,
                    'booking_day' => $booking->booking_day,
                    'start_time' => $booking->start_time_booking,
                    'end_time' => $booking->end_time_booking,
                ];
            });

        return $booking_data;
    }
}
