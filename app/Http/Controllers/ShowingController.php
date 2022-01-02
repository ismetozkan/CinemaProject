<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Showing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowingController extends Controller
{

    public function read(){
       return Showing::all()->where('removed','N');
    }

    public function create(Request $request){
        $rules = [
            'movie_id' => 'required|integer',
            'show_date' => 'required|date_format:Y-m-d H:i',
            'salon_id' => 'required|integer'
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

            $showing = new Showing();

            $result = $showing::create([
                'movie_id' => $request->movie_id,
                'show_date' => $request->show_date,
                'salon_id' => $request->salon_id
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

    public function delete(Request $request,$id)
    {
      $result = Showing::where('id', $id)->update([
            'removed' => 'Y'
        ]);
        return response()->json([
            'code' => $result  ? '200' : '400',
            'message' => $result
                ? 'Başarılı'
                : 'Başarısız',
        ],$result  ? '200' : '400');
    }

    public function update(Request $request,$id){
        $result = Showing::where('id', $id)->update($request->all());
        return response()->json([
            'code' => $result ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result ? '200' : '400',
            ],
        ]);
    }

    public function show(Request $request,$id){
        $result = Showing::where('id', $id)->get();
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
