<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{

    public function read(){
        return Movie::all()->where('removed','N');
    }



    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'message' => 'Lütfen formu eksiksiz doldurun.',
                'result' => $validator->errors()->messages()
            ]);
        }else{
            $movie = new Movie();
            $result = $movie::create([
                'title' => $request->title
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
        $result = Movie::where('id', $id)->update(['title' => $request->title]);
        return response()->json([
            'code' => $result ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result ? '200' : '400',
            ],
        ]);
    }


    public function delete(Request $request,$id)
    {
        $result = Movie::where('id', $id)->update([
            'removed' => 'Y'
        ]);
        return response()->json([
            'code' => $result  ? '200' : '400',
            'message' => $result
                ? 'Başarılı'
                : 'Başarısız',
        ],$result  ? '200' : '400');
    }

    public function show(Request $request,$id)
    {
        $result = Movie::where('id', $id)->get();
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
