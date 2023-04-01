<?php

namespace App\Http\Controllers;

use App\Models\Requst;
use Illuminate\Http\Request;

class RequstController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Requst::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requst = Requst::create($request->all()); 
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $employee_num_id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_num_id)
    {
        if (filled($employee_num_id) && is_numeric($employee_num_id)) {
            $data = Requst::where('employee_num_id', $employee_num_id)->get();
            if ($data)
                return $data;
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
    public function update(Request $request,Requst $requst)
    {
        $requst->update($request->all());
        return $requst;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requst $requst)
    {
        $requst->delete();
        return response('',204);
    }
}
