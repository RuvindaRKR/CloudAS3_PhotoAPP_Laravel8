<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
            'title'=>'required',
            'description'=>'required'
        ]);

        $photo = new Photo();
        $photo->user_id = $request->user();
        $photo->photo_path = $request->file('photo')->store('photo-uploads');
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->likes = 0;

        $photo->save();

        return response('Successfully Uploaded Photo', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Photo::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
            'title'=>'required',
            'description'=>'required'
        ]);

        $photo = Photo::find($id);
        $photo->user_id = $request->user();
        $photo->photo_path = $request->file('photo')->store('photo-uploads');
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->likes = 0;

        $photo->save();

        return response('Successfully Updated Photo', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Photo::find($id)->delete();
        return response('Successfully Deleted Photo', 200);
    }
}
