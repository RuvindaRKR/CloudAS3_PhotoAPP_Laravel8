<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'photo_id'=>'required',
            'comment'=>'required'
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user();
        $comment->photo_id = $request->photo_id;
        $comment->comment = $request->comment;

        $comment->save();

        return response('Successfully Added Comment', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::find($id);
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
        $this->validate($request,[
            'photo_id'=>'required',
            'comment'=>'required'
        ]);

        $comment = Comment::find($id);
        $comment->user_id = $request->user();
        $comment->photo_id = $request->photo_id;
        $comment->comment = $request->comment;

        $comment->save();

        return response('Successfully Updated Comment', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::find($id)->delete();
        return response('Successfully Deleted Comment', 200);
    }
}
