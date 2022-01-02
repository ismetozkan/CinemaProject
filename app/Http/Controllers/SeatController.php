<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    public function read(){
        return Salon::all()->where('removed','N');
    }

    public function create(Request $request){
        $rules = [
            'group' => 'required|string',
            'seat_no' => 'nullable|integer',
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
            $seat = new Seat();
            $result = $seat::create([
                'group' => $request->group,
                'seat_no' => $request->seat_no,
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

    public function delete(Request $request,$id){
        $result = Seat::where('id', $id)->update([
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
        $result = Seat::where('id', $id)->update($request->all());
        return response()->json([
            'code' => $result  ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result  ? '200' : '400',
            ],
        ]);
    }

    public function show(Request $request,$id){
        $result = Seat::where('id', $id)->get();
        return response()->json([
            'code' => $result->count()  ? '200' : '400',
            'message' => [
                'result' => $result->count() ? $result : 'Görüntülenecek veri bulunmamaktadır.',
                'route_name' => $request->route()->getName(),
                'code' => $result->count()  ? '200' : '400',
            ],
        ]);
    }
}
