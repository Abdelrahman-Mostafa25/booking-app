<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRrequest;
use App\Http\Requests\Employee\UpdateEmployeeRrequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Employee::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRrequest $request)
    {
        $employee = $request->all();
        $concatenatedData = 
        $request->get('employee_name') . 
        '-' . $request->get('email') . 
        '-' . $request->get('password') . 
        '-' . $request->get('phone_num') . 
        '-' . $request->get('specialization');
        
        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:employees,concatenated_data',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'There is an employee is already exite.'], 422);
        }   
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        DB::table('employees')->insert([
            'employee_name' => $request->get('employee_name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'phone_num' => $request->get('phone_num'),
            'specialization' => $request->get('specialization'),
            'concatenated_data' => $concatenatedData,
            ]);
    
        return $employee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
        if (filled($employee_id) && is_numeric($employee_id)) {
            $hall = Employee::find($employee_id);
            if ($hall)
                return $hall;
            else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
        return Employee::findorFail($employee_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRrequest $request, $employee)
    {
        if (filled($employee) && is_numeric($employee)) {
            $Employees = Employee::find($employee);
            if ($Employees) {
                $Employees->fill($request->all());
                $concatenatedData =
                    $Employees->employee_name .
                    '-' . $Employees->email .
                    '-' . $Employees->password .
                    '-' . $Employees->phone_num .
                    '-' . $Employees->specialization;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $Employees->concatenated_data = $concatenatedData;
                $Employees->save();
                return $Employees;
            } else
                return "Not Found";
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
        return $employee;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee)
    {
        if (filled($employee) && is_numeric($employee)) {
            $found = Employee::find($employee);
            if ($found) {
                $found->delete();
                return response('', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}
