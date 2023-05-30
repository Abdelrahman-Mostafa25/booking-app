<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teach\CreateTeachRrequest;
use App\Http\Requests\Teach\UpdateTeachRrequest;
use App\Models\Teache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Teache::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTeachRrequest $request)
    {
        $teache = $request->all();
        $course_code = str_replace(' ', '', $request->get('course_code'));
        // check if the employee exists in the halls table
        $existingcourse = DB::table('courses')
            ->where('code',  $course_code)
            ->first();

        if (!$existingcourse) {
            return response()->json(['message' => 'Course does not exist.'], 422);
        }

        // check if the Course exists in the halls table
        $existingemplyee = DB::table('employees')
            ->where('employee_id', $request->get('employee_num_id'))
            ->first();

        if (!$existingemplyee) {
            return response()->json(['message' => 'Emplyee does not exist.'], 422);
        }

        $concatenatedData =
            $request->get('course_code') .
            '-' . $request->get('employee_num_id');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:teaches,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an employee is already exite.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        
        DB::table('teaches')->insert([
            'employee_num_id' => $request->get('employee_num_id'),
            'course_code' => $course_code,
            'concatenated_data' => $concatenatedData,
        ]);

        return $teache;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $employee_num_id
     * @param  string  $course_code
     * @return \Illuminate\Http\Response
     */
    public function show($employee_num_id, $course_code)
    {
        if (filled($employee_num_id) && filled($course_code) && is_numeric($employee_num_id) && is_string($course_code)) {
            $teach =  Teache::where('employee_num_id', $employee_num_id)->where('course_code', $course_code)->get();
            if ($teach->isNotEmpty())
                return $teach;
            else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $employee_num_id
     * @param  string  $course_code
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeachRrequest $request, $employee_num_id, $course_code)
    {
        if (!is_numeric($employee_num_id) && !filled($employee_num_id)) {
            return response()->json(['message' => 'Invalid employee number.'], 400);
        }

        // Check if course_code is valid
        if (!is_string($course_code) && !filled($course_code)) {
            return response()->json(['message' => 'Invalid course code.'], 400);
        }

        // Check if record exists
        $teach = Teache::where('course_code', $course_code)
            ->where('employee_num_id', $employee_num_id)
            ->first();


        if (!$teach) {
            return response()->json(['message' => 'Record not found.'], 404);
        }
        // Update record with new data
        DB::table('teaches')
            ->where('employee_num_id', $employee_num_id)
            ->where('course_code', $course_code)
            ->update($request->all());

        // Update concatenated_data with new values
        $concatenatedData = $request->course_code . '-' . $request->employee_num_id;
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        DB::table('teaches')
        ->where('employee_num_id', $request->employee_num_id)
        ->where('course_code', $request->course_code)
        ->update(['concatenated_data' => $concatenatedData]);

        // Return updated record
        return response()->json($teach);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee_num_id, $course_code)
    {
        if (filled($employee_num_id) && filled($course_code) && is_numeric($employee_num_id) && is_string($course_code)) {
            $teach =  Teache::where('employee_num_id', $employee_num_id)->where('course_code', $course_code)->get();
            if ($teach->isNotEmpty()) {
                $teach->delete();
                return response('', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }

    public function show_doctor_courses($employee_num_id)
    {
        if (filled($employee_num_id) && is_numeric($employee_num_id)) {
            $course = DB::table('teaches')
            ->where('employee_num_id','=' ,$employee_num_id)
            ->get()->map(function ($courses) {
                return [
                    'course_name' =>  DB::table('courses')->where('code', $courses->course_code)->first()->course_name,
                    'course-code' => DB::table('courses')->where('code', $courses->course_code)->first()->code,
                ];
            });
            return $course;
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}