<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'uploadedPhoto' => ['required', 'mimes:jpg,jpeg,png', 'max:10240'],
            'title'=>'required',
            'description'=>'required'
        ]);

        $photo = new Photo();
        $photo->user_id = $request->user()->id;
        //Reference: [3]"File Storage - Laravel - The PHP Framework For Web Artisans", Laravel.com, 2021. [Online]. Available: https://laravel.com/docs/8.x/filesystem#specifying-a-disk. [Accessed: 07- Jun- 2021].
        $photo->photo_path = $request->file('uploadedPhoto')->store('photo-uploads/'.$request->user()->id, 's3');
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->likes = 0;
        $photo->rank = 0;
        $photo->created_at = Carbon::now();
        $photo->updated_at = Carbon::now();

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
            'uploadedPhoto' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
            'title'=>'required',
            'description'=>'required'
        ]);

        $photo = Photo::find($id);
        $photo->user_id = $request->user();
        $photo->photo_path = $request->file('uploadedPhoto')->store('photo-uploads');
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
