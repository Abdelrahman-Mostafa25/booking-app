<?php

namespace App\Http\Controllers;

use App\Models\Supervisor_info;
use Illuminate\Http\Request;

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
        return Supervisor_info::findorFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Supervisor_info $supervisor_info)
    {
        $supervisor_info->update($request->all());
        return $supervisor_info;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supervisor_info $supervisor_info)
    {
        $supervisor_info->delete();
        return response('',204);
    }
}
