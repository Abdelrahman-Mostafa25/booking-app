<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requst\CreatRequst;
use App\Models\Employee;
use App\Models\Hall;
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
            // Convert time format from 24-hour to 12-hour
            $start_time = date("g:i A", strtotime($request->start_time_booking));
            $end_time = date("g:i A", strtotime($request->end_time_booking));
            // Convert date_time_send and update_request to 12-hour style
            $date_time_send = date('Y-m-d g:iA', strtotime($request->date_time_send));
            $update_request = date('Y-m-d g:iA', strtotime($request->update_request));
            $response = $request;
            $response['start_time_booking'] = $start_time;
            $response['end_time_booking'] = $end_time;
            $response['employee_email'] = $employee->email;
            $response['employee_name'] = $employee->employee_name;
            $response['date_time_send'] = $date_time_send;
            $response['update_request'] = $update_request;
            $responses[] = $response;
        }
        return array_reverse($responses);
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
            $responses = [];
            if ($data) {
                foreach ($data as $request) {
                    $employee = Employee::findOrFail($request->employee_num_id);
                    $hall = Hall::findOrFail($request->hall_num);
                    // Convert time format from 24-hour to 12-hour
                    $start_time = date("g:i A", strtotime($request->start_time_booking));
                    $end_time = date("g:i A", strtotime($request->end_time_booking));
                    // Convert date_time_send and update_request to 12-hour style
                    $date_time_send = date('Y-m-d g:iA', strtotime($request->date_time_send));
                    $update_request = date('Y-m-d g:iA', strtotime($request->update_request));
                    $response = $request;
                    $response['hall_name'] = $hall->hall_name;
                    $response['employee_email'] = $employee->email;
                    $response['employee_name'] = $employee->employee_name;
                    $response['start_time_booking'] = $start_time;
                    $response['end_time_booking'] = $end_time;
                    $response['date_time_send'] = $date_time_send;
                    $response['update_request'] = $update_request;
                    $responses[] = $response;
                }
                return response()->json($responses);
            } else
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
    public function request_seen($request_num_id)
    {
        if (filled($request_num_id) && is_numeric($request_num_id)) {
            $data = Requst::where('request_num_id', $request_num_id)->get();
            $responses = [];
            if ($data) {
                // Update is_seen field to 1 for each record
                Requst::where('request_num_id', $request_num_id)->update(['is_seen' => True]);
                $data = Requst::where('request_num_id', $request_num_id)->get();
                foreach ($data as $request) {
                    $employee = Employee::findOrFail($request->employee_num_id);
                     // Convert time format from 24-hour to 12-hour
                    $start_time = date("g:i A", strtotime($request->start_time_booking));
                    $end_time = date("g:i A", strtotime($request->end_time_booking));
                    // Convert date_time_send and update_request to 12-hour style
                    $date_time_send = date('Y-m-d g:iA', strtotime($request->date_time_send));
                    $update_request = date('Y-m-d g:iA', strtotime($request->update_request));
                    $response = $request;
                    $response['employee_email'] = $employee->email;
                    $response['employee_name'] = $employee->employee_name;
                    $response['start_time_booking'] = $start_time;
                    $response['end_time_booking'] = $end_time;
                    $response['date_time_send'] = $date_time_send;
                    $response['update_request'] = $update_request;
                    $responses[] = $response;
                }

                return response()->json($data);
            } else {
                return "Not Found";
            }
        } else {
            return response()->json(['message' => 'Invalid input.'], 400);
        }
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
            $responses = [];
            if ($data) {
                foreach ($data as $request) {
                    // Convert time format from 24-hour to 12-hour
                    $start_time = date("g:i A", strtotime($request->start_time_booking));
                    $end_time = date("g:i A", strtotime($request->end_time_booking));
                    // Convert date_time_send and update_request to 12-hour style
                    $date_time_send = date('Y-m-d g:iA', strtotime($request->date_time_send));
                    $update_request = date('Y-m-d g:iA', strtotime($request->update_request));
                    $response = $request;            
                    $response['start_time_booking'] = $start_time;
                    $response['end_time_booking'] = $end_time;
                    $response['date_time_send'] = $date_time_send;
                    $response['update_request'] = $update_request;
                    $responses[] = $response;
                }
                return response()->json($responses);
            } else
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
    public function showrespond($employee_num_id)
    {
        if (filled($employee_num_id) && is_numeric($employee_num_id)) {
            $data = Requst::where('employee_num_id', $employee_num_id)
                ->where('respond_state', '<>', 0)
                ->get();
            $responses = [];
            if ($data) {
                foreach ($data as $request) {
                    $employee = Employee::findOrFail($request->employee_num_id);
                    // Convert time format from 24-hour to 12-hour
                    $start_time = date("g:i A", strtotime($request->start_time_booking));
                    $end_time = date("g:i A", strtotime($request->end_time_booking));
                    // Convert date_time_send and update_request to 12-hour style
                    $date_time_send = date('Y-m-d g:iA', strtotime($request->date_time_send));
                    $update_request = date('Y-m-d g:iA', strtotime($request->update_request));
                    $response = $request;
                    $response['employee_email'] = $employee->email;
                    $response['employee_name'] = $employee->employee_name;
                    $response['start_time_booking'] = $start_time;
                    $response['end_time_booking'] = $end_time;
                    $response['date_time_send'] = $date_time_send;
                    $response['update_request'] = $update_request;
                    $responses[] = $response;
                }
                return response()->json($responses);
            } else
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
    public function update(Request $request, Requst $requst)
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
        return response('', 204);
    }
}
