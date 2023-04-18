<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requst\CreatRequst;
use App\Models\Employee;
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
        $requests = Requst::all();
        $responses = [];
        foreach ($requests as $request) {
            $employee = Employee::findOrFail($request->employee_num_id);
            $response = $request;
            $response['employee_email'] = $employee->email;
            $response['employee_name'] = $employee->employee_name;
            $responses[] = $response;
        }
        return $responses;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatRequst $request)
    {
        $requst = Requst::create($request->all()); 
        return $requst;
    }

 /**
     * Display the specified resource.
     *
     * @param  int  $employee_num_id
     * @return \Illuminate\Http\Response
     */
    public function showreq($request_num_id)
    {
        if (filled($request_num_id) && is_numeric($request_num_id)) {
            $data = Requst::where('request_num_id', $request_num_id)->get();
            if ($data)
                return response()->json($data);
            else
                return "Not Found";
        } else
            return response()->json(['message' => 'Invalid input.'], 400);
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
