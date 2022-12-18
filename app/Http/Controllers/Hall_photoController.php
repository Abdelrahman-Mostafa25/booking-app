<?php

namespace App\Http\Controllers;

use App\Models\Hall_photo;
use Illuminate\Http\Request;

class Hall_photoController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hall_photo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hall_photo = $request->hasFile('image');
        if($hall_photo)
        {
            $new_photo = $request->file('thumbnail');
            $photo_path = $new_photo->store('images');
            return $photo_path;
        }
        
    }// 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Hall_photo::findorFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Hall_photo $hall_photo)
    {
        $hall_photo->update($request->all());
        return $hall_photo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall_photo $hall_photo)
    {
        $hall_photo->delete();
        return response('',204);
    }
}
