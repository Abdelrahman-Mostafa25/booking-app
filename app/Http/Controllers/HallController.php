<?php

namespace App\Http\Controllers;

use App\Http\Requests\Halls\CreateHallRrequest;
use App\Http\Requests\Halls\UpdateHallRrequest;
use App\Models\Hall;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HallController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hall::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHallRrequest $request)
    {
        $hall = $request->all();
        $concatenatedData = $request->get('hall_name') . 
        '-' . $request->get('capacity') . 
        '-' . $request->get('has_monitor') . 
        '-' . $request->get('has_projector') . 
        '-' . $request->get('has_air_condition') . 
        '-' . $request->get('is_special') . 
        '-' . $request->get('type') . 
        '-' . $request->get('status') . 
        '-' . $request->get('description_place') . 
        '-' . $request->get('floor_place') . 
        '-'. $request->get('building_place');
        
        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:halls,concatenated_data',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'There is an Hall is already exite.'], 422);
        }

        DB::table('halls')->insert([
            'hall_name' => $request->get('hall_name'),
            'capacity' => $request->get('capacity'),
            'has_monitor' => $request->get('has_monitor'),
            'has_projector' => $request->get('has_projector'),
            'has_air_condition' => $request->get('has_air_condition'),
            'is_special' => $request->get('is_special'),
            'type' => $request->get('type'),
            'status' => $request->get('status'),
            'description_place' => $request->get('description_place'),
            'floor_place' => $request->get('floor_place'),
            'building_place' => $request->get('building_place'),
            'concatenated_data' => $concatenatedData,
            ]);
    
        return $hall;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (filled($id) && is_numeric($id))
        {
            $hall = Hall::find($id);
            if ($hall)
                return $hall;
            else
                return "Not Found"; 
        }
        else
            return response()->json(['message' => 'Invalid input.'], 400);     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $hall
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHallRrequest $request,$hall)
    {
        if (filled($hall) && is_numeric($hall)) {
            $bookings =DB::table('halls')
            ->where('hall_id',$hall)
            ->update($request->all());
            return response()->json($bookings);
            } 
        else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $hall
     * @return \Illuminate\Http\Response
     */
    public function destroy($hall)
    {
        if (filled($hall) && is_numeric($hall))
        {
            $found = Hall::find($hall);
            if ($found)
                {
                    $found->delete();
                    return response('',204);
                }
            else
                return "Not Found"; 
        }
        else
            return response()->json(['message' => 'Invalid input.'], 400);
        
    }
}
