<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\CinemaToMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CinemaToMovieController extends Controller
{
    public function read(){
        //return CinemaToMovie::get();
        return CinemaToMovie::all()->where('showings','Y')->toArray();
    }

    public function create(Request $request)
    {
        $rules = [
            'cinema_id' => 'required|integer',
            'movie_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'Lütfen formu eksiksiz doldurun.',
                'result' => $validator->errors()->messages()
            ],400);
        }else{
            $cinemaToMovie = new CinemaToMovie();
            $result = $cinemaToMovie::create([
                'cinema_id' => $request->cinema_id,
                'movie_id' => $request->movie_id,
                'start' => $request->start,
                'end' => $request->end
            ]);

            if($result)
            {
                return response()->json([
                    'code' => 200,
                    'message' => [
                        'route_name' => $request->route()->getName(),
                        'code' => 200
                    ],
                    'result' => $result
                ]);
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => [
                        'route_name' => $request->route()->getName(),
                        'code' => 400
                    ]
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $result = CinemaToMovie::where('id', $id)->update(['title' => $request->title]);
        return response()->json([
            'code' => $result ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result ? '200' : '400',
            ],
        ]);
    }

/*
    public function destroy(Request $request,$id)
    {
        $result = CinemaToMovie::where('id',$id)->delete();
        return response()->json([
            'code' => $result ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result ? '200' : '400',
            ],
        ]);
    }
*/
    public function show(Request $request,$id){
        $result = CinemaToMovie::where('id', $id)->get();
        return response()->json([
            'code' => $result->count() ? '200' : '400',
            'message' => [
                'result' => $result->count() ? $result : 'Görüntülenecek veri bulunmamaktadır.',
                'route_name' => $request->route()->getName(),
                'code' => $result->count() ? '200' : '400',
            ],
        ]);
    }
}
