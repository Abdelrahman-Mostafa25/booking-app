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
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $path = 'image/hall_photos';
        $uploaded_photos = [];

        foreach ($request->photos as $photo) {
            $imageName = time() . '.' . $photo->extension();
            $photo->move(public_path($path), $imageName);
            $uploaded_photos[] = $path . '/' . $imageName;
        }

        // do something with the $uploaded_photos array, like storing it in the database or processing it in some way

        return response()->json([
            'message' => 'Photos uploaded successfully',
            'data' => $uploaded_photos
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Hall_photo::where('hall_num_id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $id2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id2)
    {
        $hall_photo = Hall_photo::where('hall_num_id', $id)
            ->where('counter_id', $id2)->get();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $imageName = time() . '.' . $request->photo->extension();
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
    public function destroy($id, $id2)
    {
        $hall_supervisor =  Hall_photo::where('hall_num_id', $id)->where('counter_id', $id2);
        $hall_supervisor->delete();
        return response('', 204);
    }
}
