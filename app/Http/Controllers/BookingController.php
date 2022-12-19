<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $booking = Booking::create($request->all()); 
        return $booking;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *  @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id1,$id2)
    {
        return Booking::where('employee_num_id',$id1)->where('hall_num_id',$id2)->firstOrFail(); 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id1
     *  @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id1,$id2)
    {
        
        return DB::table('bookings')
        ->where('employee_num_id',$id1)
        ->where('hall_num_id',$id2)
        ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id1
     * * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy($id1,$id2)
    {
        $booking = Booking::where('employee_num_id',$id1)->where('hall_num_id',$id2);
        $booking->delete();
        return response('',204);
    }
}
