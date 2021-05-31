<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::all();
        return response($albums);
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
            'title' => 'required|string'
        ]);

        $album = new Album();

        $album->title = $request->title;
        $album->artist = $request->artist;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'album-'.time().'.'.$ext;
            $album->image = '/image/album/'.$cover;
            $path = 'image/album';
            $image->move($path, $cover);
        }else{
            $album->image = '/image/album/album.jpg';
        }

        $album->save();

        return response($album);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::findOrFail($id);
        return response($album);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        $albums = Album::where('title', 'LIKE', '%'.$search.'%')->get();
        return response($albums);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        $album = Album::findOrFail($id);

        $album->title = $request->title;
        $album->artist = $request->artist;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'album-'.time().'.'.$ext;
            $album->image = '/image/album/'.$cover;
            $path = 'image/album';
            $image->move($path, $cover);
        }

        $album->update();

        return response($album);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return response(['message' => 'Album deleted successfuly']);
    }
}
