<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRrequest;
use App\Http\Requests\Employee\UpdateEmployeeRrequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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

        $imageName = null;
        $path = 'image/employee_photo';

        if ($request->hasFile('employee_photo')) {
            $imageName = time().'.'.$request->employee_photo->extension();
            $request->employee_photo->move(public_path($path), $imageName);
        }

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
            return response()->json(['message' => 'There is an employee already exists.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);


        $hashedPassword = Hash::make($request->get('password'));
        $employee_id = DB::table('employees')->insertGetId([
            'employee_name' => $request->get('employee_name'),
            'email' => $request->get('email'),
            'password' => $hashedPassword,
            'phone_num' => $request->get('phone_num'),
            'specialization' => $request->get('specialization'),
            'concatenated_data' => $concatenatedData,
            'employee_photo' => $imageName ? $path.'/'.$imageName : null,
        ]);

        $inserted_employee = DB::table('employees')->where('employee_id', $employee_id)->first();
        $response = [
            'employee_id' => $inserted_employee->employee_id,
            'employee_name' => $inserted_employee->employee_name,
            'email' => $inserted_employee->email,
            'password' => $inserted_employee->password,
            'phone_num' => $inserted_employee->phone_num,
            'specialization' => $inserted_employee->specialization,
            // 'employee_photo' => $inserted_employee->employee_photo,

        ];
        return response()->json($response);
        
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateEmployeeRrequest $request, $employee)
    // {
    //     if (filled($employee) && is_numeric($employee)) {
    //         $Employees = Employee::find($employee);
    //         if ($Employees) {
    //             $Employees->fill($request->all());

    //             // Handle file upload
    //             if ($request->hasFile('employee_photo')) {
    //                 $imageName = time() . '.' . $request->employee_photo->extension();
    //                 $path = 'image/employee_photo';
    //                 $request->employee_photo->move(public_path($path), $imageName);
    //                 $Employees->employee_photo = $imageName;
    //             }

    //             $concatenatedData =
    //                 $Employees->employee_name .
    //                 '-' . $Employees->email .
    //                 '-' . $Employees->password .
    //                 '-' . $Employees->phone_num .
    //                 '-' . $Employees->specialization;
    //             $concatenatedData = str_replace(' ', '', $concatenatedData);
    //             $Employees->concatenated_data = $concatenatedData;
    //             $Employees->save();
    //             return $Employees;
    //         } else
    //             return "Not Found";
    //     } else {
    //         return response()->json(['message' => 'Invalid input.'], 400);
    //     }
    //     return $employee;
    // }
    public function update(UpdateEmployeeRrequest $request, $employee)
    {
        if (filled($employee) && is_numeric($employee)) {
            $employeeModel = Employee::find($employee);
            if ($employeeModel) {
                $employeeModel->fill($request->all());
    
                // Handle email update
                if ($request->has('email')) {
                    $newEmail = $request->email;
                    $existingEmployee = Employee::where('email', $newEmail)->first();
                    if ($existingEmployee && $existingEmployee->employee_id !== $employeeModel->employee_id) {
                        return response()->json(['message' => 'Email already exists.'], 409);
                    }
                    $employeeModel->email = $newEmail;
                }
    
                // Handle password update
                if ($request->has('password')) {
                    $hashedPassword = Hash::make($request->password);
                    $employeeModel->password = $hashedPassword;
                }
    
                // Handle file upload
                if ($request->hasFile('employee_photo')) {
                    $imageName = time() . '.' . $request->employee_photo->extension();
                    $path = 'image/employee_photo';
                    $request->employee_photo->move(public_path($path), $imageName);
                    $employeeModel->employee_photo = $imageName;
                }
    
                // Update concatenated data
                $concatenatedData =
                    $employeeModel->employee_name .
                    '-' . $employeeModel->email .
                    '-' . $employeeModel->password .
                    '-' . $employeeModel->phone_num .
                    '-' . $employeeModel->specialization;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $employeeModel->concatenated_data = $concatenatedData;
    
                // Save changes
                $employeeModel->save();
                
                return $employeeModel;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login_function($email, $password)
    {
        $employee = DB::table('employees')->where('email', $email)->first();
        if ($employee && Hash::check($password, $employee->password)) {
            return $employee->employee_id;
        } else
            return -1;
    }
}
