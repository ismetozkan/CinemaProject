<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieDetail;
use Illuminate\Http\Request;

class MovieDetailController extends Controller
{
    public function read(){
        return MovieDetail::all()->where('removed','N');
        /*return response()->json([
           MovieDetail::get()
        ]);*/
    }

    public function create(Movie $movie,Request $request)
    {
        if ($request->hasFile('cover')) {

            $request->validate([
                'cover' => 'mimes:jpeg,bmp,png'
            ]);
            $request->file->create('covers', 'public');

            $movie->details()->create([
                'long' => $request->long,
                "cover" => $request->cover->hashName()
            ]);
            return response()->json([
                "result" => "true"
            ]);
        }
    }

    public function show($id)
    {
        return response()->json([
            MovieDetail::where('id',$id)->get()
        ]);
    }

  /*
    public function update(Request $request, $id)
    {
        //Gelen isteklerin kontrollerinin sağlanacağı sınıf yazılacak.
        if ($request->hasFile('cover'))
        {
            $request->validate([
                'cover' => 'mimes:jpeg,bmp,png|required'
            ]);
            $request->file->create('covers', 'public');

            $mov = MovieDetail::find($id);
            $mov->movie_id = is_null($request->long) ? $mov->long : $request->long;
            $mov->cover = is_null($request->cover) ? $mov->cover :$request->cover->hashName() ;
            $mov->save();
        }
        return response()->json([
            'result' => 'true'
        ]);
    }
*/

/*
    public function destroy($id)
    {
        return response()->json([
            'result' => MovieDetail::where('id',$id)->delete() == 1 ? 'true' : 'false'
        ]);
    }
*/

}
