<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::limit(6)->get();
        return response($songs);
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
            'title' => 'required|string',
            'audio' => 'required'
        ]);

        $song = new Song();

        $song->title = $request->title;
        $song->artist = !$request->artist ? 'Unknown' : $request->artist;
        $song->album = !$request->album ? 'Unknown' : $request->album;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'song-'.time().'.'.$ext;
            $song->image = '/image/song/'.$cover;
            $path = 'image/song';
            $image->move($path, $cover);
        }else{
            $song->image = '/image/song/song.jpg';
        }

        // add audio
        $audio = $request->file('audio');
        $ext = $audio->getClientOriginalExtension();
        $audiocover = 'audio-'.time().'.'.$ext;
        $song->audio = '/audio/'.$audiocover;
        $path = 'audio';
        $audio->move($path, $audiocover);


        $song->save();

        return response($song);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $song = Song::findOrFail($id);
        return response($song);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        $songs = Song::where('title', 'LIKE', '%'.$search.'%')->orWhere('album', 'LIKE', '%'.$search.'%')->orWhere('artist', 'LIKE', '%'.$search.'%')->get();
        return response($songs);
    }

    public function fieldSearch($field, $search)
    {
        $songs = Song::where($field, 'LIKE', '%'.$search.'%')->limit(12)->get();
        return response($songs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        $song = Song::findOrFail($id);

        $song->title = $request->title;
        $song->artist = !$request->artist ? $song->artist : $request->artist;
        $song->album = !$request->album ? $song->album : $request->album;

        // add image
        $image = $request->file('image');
        if($image){
            $ext = $image->getClientOriginalExtension();
            $cover = 'song-'.time().'.'.$ext;
            $song->image = '/image/song/'.$cover;
            $path = 'image/song';
            $image->move($path, $cover);
        }

        $song->update();

        return response($song);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();
        return response(['message' => 'Song deleted successfuly']);
    }
}
