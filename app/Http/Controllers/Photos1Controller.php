<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class Photos1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Photo::all();
        return Inertia::render('MyPhotos1', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'uploadedPhoto' => ['required', 'mimes:jpg,jpeg,png', 'max:10240'],
            'title' => ['required'],
            'description' => ['required'],
        ])->validate();

        $photo = new Photo();
        $photo->user_id = $request->user()->id;
        //Reference: [3]"File Storage - Laravel - The PHP Framework For Web Artisans", Laravel.com, 2021. [Online]. Available: https://laravel.com/docs/8.x/filesystem#specifying-a-disk. [Accessed: 07- Jun- 2021].
        $photo->photo_path = $request->file('uploadedPhoto')->storePublicly('photo-uploads/'.$request->user()->id, 's3');
        $photo->title = $request->title;
        $photo->description = $request->description;
        $photo->likes = 0;
        $photo->rank = 0;
        $photo->created_at = Carbon::now();
        $photo->updated_at = Carbon::now();

        $photo->save();

        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
        ])->validate();

        if ($request->has('id')) {
            $photo = Photo::find($request->input('id'));
            $photo->title = $request->title;
            $photo->description = $request->description;

            $photo->save();
            return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Photo::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
