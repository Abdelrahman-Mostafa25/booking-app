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
        $course_code = str_replace(' ', '', $course_code);

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
    public function show($teach_id)
    {
        if (filled($teach_id) && is_numeric($teach_id)) {
            $teach =  Teache::where('id', $teach_id)->get();
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
    public function update(UpdateTeachRrequest $request, $teach_id)
    {
        if (is_numeric($teach_id) && filled($teach_id)) {
            $teach = Teache::where('id', $teach_id)->first();
            if (!$teach) {
                return response()->json(['message' => 'Record not found.'], 404);
            }
            // Update record with new data
            DB::table('teaches')->where('id', $teach_id)->update($request->all());

            // Update concatenated_data with new values
            $courseCode = $request->course_code;
            $employeeNumId = $request->employee_num_id ?? $teach->employee_num_id;

            $concatenatedData = '';
            if (filled($courseCode)) {
                $concatenatedData .= $courseCode;
            }
            if (filled($employeeNumId)) {
                if (filled($courseCode)) {
                    $concatenatedData .= '-';
                }
                $concatenatedData .= $employeeNumId;
            }

            $concatenatedData = str_replace(' ', '', $concatenatedData); // Remove spaces

            DB::table('teaches')->where('id', $teach_id)->update(['concatenated_data' => $concatenatedData]);

            // Return updated record
            $teach = Teache::where('id', $teach_id)->first();
            return response()->json($teach);
        } else {
            return "ERROR IN ID";
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($teach_id)
    {
        if (filled($teach_id) && is_numeric($teach_id)) {
            $teach = Teache::where('id', $teach_id)->delete();
            return response('', 204);
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }


    public function show_doctor_courses($employee_num_id)
    {
        if (filled($employee_num_id) && is_numeric($employee_num_id)) {
            $course = DB::table('teaches')
                ->where('employee_num_id', '=', $employee_num_id)
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
