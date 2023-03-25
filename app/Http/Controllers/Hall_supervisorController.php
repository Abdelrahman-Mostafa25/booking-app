<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hall_Supervisor\CreateHall_supervisorRrequest;
use App\Http\Requests\Hall_Supervisor\UpdateHall_supervisorRrequest;
use App\Models\Hall_supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Hall_supervisorController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hall_supervisor::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHall_supervisorRrequest $request)
    {
        $hall_supervisor = $request->all();
        // check if the hall_num exists in the halls table
        $existingHall = DB::table('halls')
            ->where('hall_id', $request->get('hall_num_id'))
            ->first();

        if (!$existingHall) {
            return response()->json(['message' => 'Hall number does not exist.'], 422);
        }
        $concatenatedData =
            $request->get('hall_num_id') .
            '-' . $request->get('counter_id') .
            '-' . $request->get('supervisor_name');
           

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:hall_supervisors,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There Supervisor is already exite.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        DB::table('hall_supervisors')->insert([
            'hall_num_id' => $request->get('hall_num_id'),
            'counter_id' => $request->get('counter_id'),
            'supervisor_name' => $request->get('supervisor_name'),
            'concatenated_data' => $concatenatedData,
        ]);

        return $hall_supervisor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $hall_num_id
     * @return \Illuminate\Http\Response
     */
    public function show($hall_num_id)
    {
        if (filled($hall_num_id) && is_numeric($hall_num_id)) {
            $hall = Hall_supervisor::where('hall_num_id',$hall_num_id)->get();
            if ($hall->isNotEmpty()) 
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
     * @param  int  $hall_num_id
     * @param  int  $counter_id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHall_supervisorRrequest $request,$hall_num_id,$counter_id)
    {
        if (filled($hall_num_id) && filled($counter_id) && is_numeric($hall_num_id) && is_numeric($counter_id)) {
            $hasll_super = Hall_supervisor::where('hall_num_id',$hall_num_id)->where('counter_id',$counter_id)->get();
            if ($hasll_super->isNotEmpty()) {
                $hasll_super = Hall_supervisor::where('hall_num_id',$hall_num_id)->where('counter_id',$counter_id)
                    ->update($request->all());

                $updatedBooking = Hall_supervisor::where('hall_num_id',$hall_num_id)->where('counter_id',$counter_id)
                    ->first();

                    $concatenatedData =
                    $request->hall_num_id.
                    '-' . $request->counter_id.
                    '-' . $request->supervisor_name;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $hasll_super = Hall_supervisor::where('hall_num_id',$hall_num_id)->where('counter_id',$counter_id)
                    ->update(['concatenated_data' => $concatenatedData]);

                return response()->json($hasll_super);
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
     * @param  int  $hall_num_id
     * @param  int  $counter_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hall_num_id,$counter_id)
    {   
        if (filled($hall_num_id) && filled($counter_id) && is_numeric($hall_num_id) && is_numeric($counter_id)) {
            $found = Hall_supervisor::where('hall_num_id',$hall_num_id)->where('counter_id',$counter_id)->get();
            if ($found->isNotEmpty())  {
                $found->delete();
                return response('', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}
