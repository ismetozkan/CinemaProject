<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\Showing;
use App\Models\Ticket;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use APIMessage;
    public function read(Request $request){
        $filter = $request->get('type');
        $result = Ticket::all()
            ->when($filter, function ($query, $filter) {
                return $query->where('removed', $filter);
            })->toArray();

        return response()->json($this->APIMessage([
            'code' => $result ? 200 : 400,
            'message' => $request->route()->getName(),
            'result' => $result
        ]),$result ? 200 : 400);
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
            return response()->json($this->APIMessage([
                'code' => 400,
                'message' => 'Formu eksiksiz bir şekilde doldurunuz.',
                'result' => $validator->errors()
            ]),400);
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

            return  $result ?
                response()->json(
                    $this->APIMessage([
                        'code' => 201,
                        'message' => $request->route()->getName(),
                        'result' => $result
                    ]),201) :
                response()->json(
                    $this->APIMessage([
                        'code' => 400,
                        'message' => $request->route()->getName()
                    ],400)
                );
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
        return response()->json($this->APIMessage([
            'code' => $result ? 200 : 400,
            'message' => $request->route()->getName(),
            'result' => $result
        ]),$result ? 200 : 400);
    }

    public function update(Request $request,$id){
        $result = Ticket::where('id', $id)->update($request->all());
        return response()->json($this->APIMessage([
            'code' => $result ? 200 : 400,
            'message' => $request->route()->getName(),
            'result' => $result
        ]),$result ? 200 : 400);
    }
}
