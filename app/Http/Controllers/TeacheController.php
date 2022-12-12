<?php

namespace App\Http\Controllers;

use App\Models\Teache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $teache = Teache::create($request->all()); 
        return $teache;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id1
     * @param  string  $id2
     * @return \Illuminate\Http\Response
     */
    public function show($id1,$id2)
     {
          $teach =  Teache::where('employee_num_id',$id1)->where('course_code',$id2)->firstOrFail();
          return $teach;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id1
     * @param  string  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id1,$id2)
    {
        return DB::table('teaches')
        ->where('employee_num_id',$id1)
        ->where('course_code',$id2)
        ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id1,$id2)
    {
        $teach =  Teache::where('employee_num_id',$id1)->where('course_code',$id2);
        $teach->delete();
        return response('',204);
    }
}
