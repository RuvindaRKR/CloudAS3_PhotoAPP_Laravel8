<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Likes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $data = Photo::where('user_id', '!=' , $user->id)->orWhereNull('user_id')->get();

        $likes = Likes::where('user_id', $user->id)->get();

        return Inertia::render('Dashboard', ['data' => $data, 'likes' => $likes]);
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
        $user = $request->user();

        $photo = Photo::find($id);
        $photo->likes = $photo->likes + 1;
        $photo->save();
        
        $like = new Likes();
        $like->user_id = $user->id;
        $like->photo_id = $id;
        $like->save();

        return redirect()->back()
                ->with('message', 'Liked Post Successfully.');

    }

    // public function destroy(Request $request, $id)
    // {
    //     $user = $request->user();
 
    //     $photo = Photo::find($id);
    //     if($photo->likes>0){
    //         $photo->likes = $photo->likes - 1;
    //         $photo->save();
    //     }
        
    //     Likes::where(
    //                 ['photo_id','=', $id],
    //                 ['user_id','=', $user->id])->delete();

    //     return redirect()->back()
    //             ->with('message', 'Liked Post Successfully.');

    // }
}
