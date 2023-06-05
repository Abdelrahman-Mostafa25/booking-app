<?php

namespace App\Http\Controllers;

use App\Http\Requests\Complainss\CreateComplainRrequest;
use App\Http\Requests\Complainss\UpdateComplainRrequest;
use App\Models\Complain;
use App\Models\Employee;
use App\Models\Hall;
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
        $complains = Complain::all();
        $formattedComplains = [];
    
        foreach ($complains as $complain) {
            $employee = Employee::findOrFail($complain->employee_num_id);
            $hall = Hall::findOrFail($complain->hall_num);
            $date_time_send = date("Y-m-d h:i:s A", strtotime($complain->date_time_send));
    
            $formattedComplain = [
                'compalin_num_id' => $complain->compalin_num_id,
                'employee_num_id' => $complain->employee_num_id,
                'hall_num' => $complain->hall_num,
                'hall_name' => $hall->hall_name,
                'text_complain' => $complain->text_complain,
                'date_time_send' => $date_time_send,
                'employee_email' => $employee->email,
                'employee_name' => $employee->employee_name
            ];
    
            $formattedComplains[] = $formattedComplain;
        }
    
        return $formattedComplains;
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
        if ($comp) {
            $employee = Employee::findOrFail($comp->employee_num_id);
            $hall = Hall::findOrFail($comp->hall_num);
            $date_time_send = date("Y-m-d h:i:s A", strtotime($comp->date_time_send));
            
            $data = [
                'compalin_num_id' => $comp->compalin_num_id,
                'employee_num_id' => $comp->employee_num_id,
                'hall_num' => $comp->hall_num,
                'hall_name' => $hall->hall_name,
                'type_hall' => $hall->type,
                'text_complain' => $comp->text_complain,
                'date_time_send' => $date_time_send,
                'employee_email' => $employee->email,
                'employee_name' => $employee->employee_name
            ];
            
            return $data;
        } else {
            return "Not Found";
        }
    } else {
        return response()->json(['message' => 'Invalid input.'], 400);
    }
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
