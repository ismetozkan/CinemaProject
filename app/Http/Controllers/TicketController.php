<?php

namespace App\Http\Controllers;

use App\Models\Showing;
use App\Models\Ticket;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function read(){
        return Ticket::all()->where('removed','N');
    }

    public function create(Request $request){
        $rules = [
            'showing_id' => 'required|integer',
            'seat_id' => 'required|integer',
            'detail' => 'required|string',
            'price' => 'required|integer',
            'type' => 'required|in:online,offline',
            'payment_status' => 'nullable|in:P,Y,N',
            'payment_method' => 'required|in:online,cash'

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
            $ticket = new Ticket();
            $result = $ticket::create([
                'showing_id' => $request->showing_id,
                'user_id' => $request->user()->id, //Auth::user()->id
                'seat_id' => $request->seat_id,
                'detail' => $request->detail,
                'price' => $request->price,
                'type' => $request->type,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method
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

    public function getByShowingId($showing_id){
        return Ticket::where('showing_id',$showing_id)->get();
    }

    public function delete(Request $request,$id){
        $result = Ticket::where('id', $id)->update([
            'removed' => 'Y'
        ]);
        return response()->json([
            'code' => $result  ? '200' : '400',
            'message' => $result
                ? 'Başarılı'
                : 'Başarısız',
        ],$result  ? '200' : '400');
    }

    public function show(Request $request,$id){
        $result = Ticket::where('id', $id)->get();
        return response()->json([
            'code' => $result->count() ? '200' : '400',
            'message' => [
                'result' => $result->count() ? $result : 'Görüntülenecek veri bulunmamaktadır.',
                'route_name' => $request->route()->getName(),
                'code' => $result->count() ? '200' : '400',
            ],
        ]);
    }

    public function update(Request $request,$id){
        $result = Ticket::where('id', $id)->update($request->all());
        return response()->json([
            'code' => $result ? '200' : '400',
            'message' => [
                'route_name' => $request->route()->getName(),
                'code' => $result ? '200' : '400',
            ],
        ]);
    }
}
