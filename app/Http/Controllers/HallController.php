<?php

namespace App\Http\Controllers;

use App\Http\Requests\Halls\CreateHallRrequest;
use App\Http\Requests\Halls\UpdateHallRrequest;
use App\Models\Hall;
use App\Models\Hall_photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $halls = Hall::all();

        foreach ($halls as $hall) {
            $hall_photos = Hall_photo::where('hall_num_id', $hall->hall_id)->get();
            $photos = [];
            foreach ($hall_photos as $photo) {
                $photos[] = $photo->photo;
            }
            $hall['photos'] = $photos;
        }
    
        return $halls;
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
        $concatenatedData =
            $request->get('hall_name') .
            '-' . $request->get('capacity') .
            '-' . $request->get('has_monitor') .
            '-' . $request->get('has_projector') .
            '-' . $request->get('has_air_condition') .
            '-' . $request->get('is_special') .
            '-' . $request->get('type') .
            '-' . $request->get('status') .
            '-' . $request->get('description_place') .
            '-' . $request->get('floor_place') .
            '-' . $request->get('building_place');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:halls,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an Hall is already exite.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
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
        if (filled($id) && is_numeric($id)) {
            $hall = Hall::find($id);
            if ($hall) {
                $photos = Hall_photo::where('hall_num_id', $id)->get();
                $photoData = [];

                foreach ($photos as $photo) {
                    $photoData[] = $photo->photo;
                }
                $hallData = [
                    'hall_id' => $hall->hall_id,
                    'hall_name' => $hall->hall_name,
                    'capacity' => $hall->capacity,
                    'has_monitor' => $hall->has_monitor,
                    'has_projector' => $hall->has_projector,
                    'has_air_condition' => $hall->has_air_condition,
                    'is_special' => $hall->is_special,
                    'type' => $hall->type,
                    'status' => $hall->status,
                    'description_place' => $hall->description_place,
                    'floor_place' => $hall->floor_place,
                    'building_place' => $hall->building_place,
                ];
            
                $responseData = [
                    'hall_data' => $hallData,
                    'photos' => $photoData,
                ];
            
                return response()->json($responseData);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $hall
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHallRrequest $request, $hall)
    {
        if (filled($hall) && is_numeric($hall)) {
            $Halls = Hall::find($hall);
            if ($Halls) {
                $Halls->fill($request->all());
                $concatenatedData =
                    $Halls->hall_name .
                    '-' . $Halls->capacity .
                    '-' . $Halls->has_monitor .
                    '-' . $Halls->has_projector .
                    '-' . $Halls->has_air_condition .
                    '-' . $Halls->is_special .
                    '-' . $Halls->type .
                    '-' . $Halls->status .
                    '-' . $Halls->description_place .
                    '-' . $Halls->floor_place .
                    '-' . $Halls->building_place;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $Halls->concatenated_data = $concatenatedData;
                $Halls->save();
                return $Halls;
            } else
                return "Not Found";
        } else {
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
        if (filled($hall) && is_numeric($hall)) {
            $found = Hall::find($hall);
            if ($found) {
                $found->delete();
                return response('', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}
