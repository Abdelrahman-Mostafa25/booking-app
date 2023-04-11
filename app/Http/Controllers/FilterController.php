<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hall;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bookingDay, $startTime, $endTime, $hall_type, $capacity_hall)
    {

        $validator = Validator::make([
            'bookingDay' => $bookingDay,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'hall_type' => $hall_type,
            'capacity_hall' => $capacity_hall
        ], [
            'bookingDay' => 'date|after_or_equal:today',
            'startTime' => 'date_format:H:i',
            'endTime' => 'date_format:H:i|after:startTime',
            'hall_type' => 'string',
            'capacity_hall' => 'integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        $eliminated_halls = DB::table('bookings')
            ->where('booking_day', '=', $bookingDay)
            ->where('type', '=', $hall_type)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time_booking', '>=', $startTime)
                        ->where('start_time_booking', '<', $endTime);
                })
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('end_time_booking', '>', $startTime)
                            ->where('end_time_booking', '<=', $endTime);
                    })
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time_booking', '<', $startTime)
                            ->where('end_time_booking', '>', $endTime);
                    });
            })
            ->pluck('hall_num_id')
            ->toArray();

        $available_halls = DB::table('halls')
            ->whereNotIn('hall_id', $eliminated_halls)
            ->where('type', '=', $hall_type)
            ->where('capacity', '=', $capacity_hall)
            ->get()->map(function ($hall) {
                $photos = DB::table('hall_photos')->where('hall_num_id', $hall->hall_id)->get();
                $photoData = [];
                foreach ($photos as $photo) {
                    $photoData[] = $photo->photo;
                }
                return [
                    'hall_id' => $hall->hall_id,
                    'hall_name' => $hall->hall_name,
                    'capacity' => $hall->capacity,
                    'is_special' => $hall->is_special,
                    'type' => $hall->type,
                    'status' => $hall->status,
                    'description_place' => $hall->description_place,
                    'floor_place' => $hall->floor_place,
                    'building_place' => $hall->building_place,
                    'hall_photos' => $photoData
                ];
            });

        return $available_halls;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
