<?php

namespace App\Http\Controllers;

use App\Models\Hall_supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $hall_supervisor = Hall_supervisor::create($request->all()); 
        return $hall_supervisor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Hall_supervisor::where('hall_num_id',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id,$id2)
    {
        return DB::table('hall_supervisors')
        ->where('hall_num_id',$id)
        ->where('counter_id',$id2)
        ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id2)
    {   $hall_supervisor =  Hall_supervisor::where('hall_num_id',$id)->where('counter_id',$id2);
        $hall_supervisor->delete();
        return response('',204);
    }
}
