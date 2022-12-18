<?php

namespace App\Http\Controllers;

use App\Models\Supervisor_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Supervisor_infoController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Supervisor_info::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supervisor_info = Supervisor_info::create($request->all()); 
        return $supervisor_info;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Supervisor_info::where('counter_id',$id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * * @param  string  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id,$id2)
    {
        return DB::table('supervisor_infos')
        ->where('counter_id',$id)
        ->where('phone_num',$id2)
        ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param   string $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id2)
    {
        $supervisor_info = Supervisor_info::where('counter_id',$id)->where('phone_num',$id2);
        $supervisor_info->delete();
        return response('',204);
    }
}
