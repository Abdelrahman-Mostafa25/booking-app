<?php

namespace App\Http\Controllers;

use App\Http\Requests\Complainss\CreateComplainRrequest;
use App\Http\Requests\Complainss\UpdateComplainRrequest;
use App\Models\Complain;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplainsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Complain::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateComplainRrequest $request)
    {
        $complain = $request->all();
        $hallNum = $request->get('hall_num');
        $employeeNumId = $request->get('employee_num_id');

        // check if the hall_num exists in the halls table
        $existingHall = DB::table('halls')
            ->where('hall_id', $hallNum)
            ->first();

        if (!$existingHall) {
            return response()->json(['message' => 'Hall number does not exist.'], 422);
        }

        // check if the employee_num_id exists in the employees table
        $existingEmployee = DB::table('employees')
            ->where('employee_id', $employeeNumId)
            ->first();

        if (!$existingEmployee) {
            return response()->json(['message' => 'Employee number does not exist.'], 422);
        }

        $concatenatedData = $employeeNumId .
            '-' . $hallNum .
            '-' . $request->get('text_complain');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:complains,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an Complain is already exite.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        DB::table('complains')->insert([
            'hall_num' => $hallNum,
            'employee_num_id' => $employeeNumId,
            'text_complain' => $request->get('text_complain'),
            'concatenated_data' => $concatenatedData,
        ]);

        return $complain;
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
            $comp = Complain::find($id);
            if ($comp)
                return $comp;
            else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComplainRrequest $request, $id)
    {
        if (filled($id) && is_numeric($id)) {
            $complain = Complain::find($id);
            if ($complain) {
                $complain->fill($request->all());
                $concatenatedData = $complain->employee_num_id . '-' . $complain->hall_num . '-' . $complain->text_complain;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $complain->concatenated_data = $concatenatedData;
                
                $complain->save();
                return $complain;
            } else
                return "Not Found";
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (filled($id) && is_numeric($id)) {
            $comp = Complain::find($id);
            if ($comp) {
                $comp->delete();
                return response('Deleting Done', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}
