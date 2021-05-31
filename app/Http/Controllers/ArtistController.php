<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::all();
        return response($artists);
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
            'name' => 'required|string'
        ]);

        $artist = new Artist();

        $artist->name = $request->name;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'artist-'.time().'.'.$ext;
            $artist->image = '/image/artist/'.$cover;
            $path = 'image/artist';
            $image->move($path, $cover);
        }else{
            $artist->image = '/image/artist/artist.jpg';
        }

        $artist->save();

        return response($artist);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        return response($artist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        $artists = Artist::where('name', 'LIKE', '%'.$search.'%')->get();
        return response($artists);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $artist = Artist::findOrFail($id);

        $artist->name = $request->name;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'artist-'.time().'.'.$ext;
            $artist->image = '/image/artist/'.$cover;
            $path = 'image/artist';
            $image->move($path, $cover);
        }

        $artist->update();

        return response($artist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();
        return response(['message' => 'Artist deleted successfuly']);
    }
}
