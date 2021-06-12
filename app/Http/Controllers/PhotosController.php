<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class PhotosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$data = Photo::all();
        $user = $request->user();
        $data = Photo::where('user_id', $user->id)->get();
        return Inertia::render('MyPhotos', ['data' => $data]);
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

        $photo->save();

        // return response('Successfully Uploaded Photo', 201);
        // return Redirect::route('photos.index');
        return redirect()->back()
                    ->with('message', 'Post Created Successfully.');
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

        $photo = Photo::find($id);
        $photo->title = $request->title;
        $photo->description = $request->description;

        $photo->save();

        return redirect()->back()
                    ->with('message', 'Post Updated Successfully.');
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
        //return response('Successfully Deleted Photo', 200);
        return redirect()->back()
                    ->with('message', 'Post Deleted Successfully.');
    }
}
