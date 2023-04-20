<?php

namespace App\Http\Controllers;

use App\Http\Requests\Courses\CreateCourseRrequest;
use App\Http\Requests\Courses\UpdateCourseRrequest;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCourseRrequest $request)
    {
        $course = $request->all();

        // check if the hall_num exists in the halls table
        $existingHall = DB::table('halls')
            ->where('hall_id', $request->get('hall_num_id'))
            ->first();

        if (!$existingHall) {
            return response()->json(['message' => 'Hall number does not exist.'], 422);
        }
        $concatenatedData =
            $request->get('code') .
            '-' . $request->get('hall_num_id') .
            '-' . $request->get('course_name') .
            '-' . $request->get('program') .
            '-' . $request->get('credit_hours') .
            '-' . $request->get('is_special') .
            '-' . $request->get('practic') .
            '-' . $request->get('semester') .
            '-' . $request->get('level');

        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:courses,concatenated_data',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'There is an Course is already exite.'], 422);
        }
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        $code = str_replace(' ', '', $request->get('code'));
        DB::table('courses')->insert([
            'code' => $code,
            'hall_num_id' => $request->get('hall_num_id'),
            'course_name' => $request->get('course_name'),
            'program' => $request->get('program'),
            'credit_hours' => $request->get('credit_hours'),
            'is_special' => $request->get('is_special'),
            'practic' => $request->get('practic'),
            'semester' => $request->get('semester'),
            'level' => $request->get('level'),
            'concatenated_data' => $concatenatedData,
        ]);

        return $course;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {

        

        if (filled($code) && is_string($code)) {
            $course = DB::table('courses')
            ->where('code', '=', $code)
            ->get();
            if ($course)
                return $course;
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
    public function update(UpdateCourseRrequest $request, $course)
    {
        if (filled($course) && is_string($course)) {
            $courses = Course::find($course);
            if ($courses) {
                $courses->fill($request->all());
                $concatenatedData =
                    $courses->code .
                    '-' . $courses->hall_num_id .
                    '-' . $courses->course_name .
                    '-' . $courses->credit_hours .
                    '-' . $courses->is_special .
                    '-' . $courses->practic .
                    '-' . $courses->semester .
                    '-' . $courses->level;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
                $courses->concatenated_data = $concatenatedData;
                $courses->save();
                return $courses;
            } else
                return "Not Found";
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
        return $course;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course)
    {
        if (filled($course) && is_string($course)) {
            $found = DB::table('courses')
            ->where('code', '=', $course)
            ->get();
            if ($found) {
                $found->delete();
                return response('', 204);
            } else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}
