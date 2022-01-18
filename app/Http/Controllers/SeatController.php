<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\Salon;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    use APIMessage;

    public function read(Request $request){
        $filter = $request->get('type');
        $result = Seat::all()
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
            'group' => 'required|string',
            'seat_no' => 'nullable|integer',
            'salon_id' => 'required|integer'
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
            $seat = new Seat();
            $result = $seat::create([
                'group' => $request->group,
                'seat_no' => $request->seat_no,
                'salon_id' => $request->salon_id
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

        return response()->json($this->APIMessage([
            'code' => $result ? 200 : 400,
            'message' => $request->route()->getName(),
            'result' => $result
        ]),$result ? 200 : 400);
    }
}
