<?php

namespace App\Http\Controllers;

use App\Models\Hall_supervisor;
use Illuminate\Http\Request;

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
        return Hall_supervisor::findorFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Hall_supervisor $hall_supervisor)
    {
        $hall_supervisor->update($request->all());
        return $hall_supervisor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_supervisor $hall_supervisor)
    {
        $hall_supervisor->delete();
        return response('',204);
    }
}
