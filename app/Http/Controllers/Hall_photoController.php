<?php

namespace App\Http\Controllers;

use App\Models\Hall_photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'hall_num_id' => 'required',
             'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        
        $imageName = time().'.'.$request->photo->extension();
        $path = 'image/hall_photos';
        // Public Folder
        $request->photo->move(public_path($path), $imageName);

       
        
         Hall_photo::create([
            'hall_num_id' => $request->hall_num_id,
            'counter_id' => $request->counter_id,   
            'photo' => $path.'/'.$imageName,
         ]);
    }// 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Hall_photo::where('hall_num_id',$id)->get();
       
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
        $hall_photo = Hall_photo::where('hall_num_id',$id)
        ->where('counter_id',$id2)->get();
        
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $imageName = time().'.'.$request->photo->extension();
            $path = 'image/hall_photos';
            // Public Folder
            $request->photo->move(public_path($path), $imageName);
             return $request;
        } else {
            return 'test';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
    * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id2)
    {   $hall_supervisor =  Hall_photo::where('hall_num_id',$id)->where('counter_id',$id2);
        $hall_supervisor->delete();
        return response('',204);
    }
}
