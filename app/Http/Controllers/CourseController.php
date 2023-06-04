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
    
        // Check if the hall_num_id exists in the halls table
        $existingHall = null;
        if ($request->has('hall_num_id')) {
            $existingHall = DB::table('halls')
                ->where('hall_id', $request->hall_num_id)
                ->first();
        }
    
        if (!$existingHall && $request->has('hall_num_id')) {
            return response()->json(['message' => 'Hall number does not exist.'], 422);
        }
    
        $concatenatedData =
            $request->get('code') .
            '-' . $request->get('hall_num_id', '') .
            '-' . $request->get('course_name') .
            '-' . $request->get('program') .
            '-' . $request->get('credit_hours') .
            '-' . $request->get('is_special') .
            '-' . $request->get('practic') .
            '-' . $request->get('section') .
            '-' . $request->get('semester') .
            '-' . $request->get('level');
    
        $validator = Validator::make(['concatenated_data' => $concatenatedData], [
            'concatenated_data' => 'unique:courses,concatenated_data',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'A course with similar data already exists.'], 422);
        }
    
        $concatenatedData = str_replace(' ', '', $concatenatedData);
        $code = str_replace(' ', '', $request->get('code'));
        
        // Prepare the data for insertion
        $courseData = [
            'code' => $code,
            'course_name' => $request->get('course_name'),
            'program' => $request->get('program'),
            'credit_hours' => $request->get('credit_hours'),
            'is_special' => $request->get('is_special'),
            'practic' => $request->get('practic'),
            'section' => $request->get('section'),
            'semester' => $request->get('semester'),
            'level' => $request->get('level'),
            'concatenated_data' => $concatenatedData,
        ];
    
        if ($request->has('hall_num_id')) {
            $courseData['hall_num_id'] = $request->get('hall_num_id');
        }
    
        DB::table('courses')->insert($courseData);
    
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
            $code = str_replace(' ', '', $code);
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
            $course = str_replace(' ', '', $course);
            $courses = DB::table('courses')
                ->where('code', '=', $course)
                ->get();
                
            if ($courses->isNotEmpty()) {
                DB::table('courses')
                    ->where('code', '=', $course)
                    ->update($request->all());
    
                $updatedCourse = DB::table('courses')
                    ->where('code', '=', $course)
                    ->first();
    
                $concatenatedData =
                    $updatedCourse->code .
                    '-' . $updatedCourse->hall_num_id .
                    '-' . $updatedCourse->course_name .
                    '-' . $updatedCourse->credit_hours .
                    '-' . $updatedCourse->is_special .
                    '-' . $updatedCourse->practic .
                    '-' . $updatedCourse->semester .
                    '-' . $updatedCourse->level;
                $concatenatedData = str_replace(' ', '', $concatenatedData);
    
                $courses = DB::table('courses')
                    ->where('code', '=', $course)
                    ->update(['concatenated_data' => $concatenatedData]);
    
                return response()->json($courses);
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
    public function destroy($course)
    {
        if (filled($course) && is_string($course)) {
            $course = str_replace(' ', '', $course);
            $found = DB::table('courses')
            ->where('code', '=', $course)
            ->delete();
                return response('', 204);
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
    }
}