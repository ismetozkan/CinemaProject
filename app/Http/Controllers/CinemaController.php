<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CinemaController extends Controller
{
    use APIMessage;
    public function read(Request $request){
        $filter = $request->get('type');
        $result = Cinema::all()
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
            'title' => 'required|string',
            'location' => 'required|string'
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
            $cinema = new Cinema();
            $result = $cinema::create([
                'title' => $request->title,
                'location' => $request->location
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


    public function update(Request $request,$id){
        $rules = [
            'title' => 'nullable|string',
            'location' => 'nullable|string'
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
            $result = Cinema::find($id);

            if (!is_null($result) && $result->removed == 'N'){
                $result->title = $request->get('title') ?? $result->title;
                $result->location = $request->get('location') ? $request->get('location')  : $result->location;
                $result->save();
                return response()->json(
                    $this->APIMessage([
                        'code' => 200,
                        'message' => $request->route()->getName(),
                        'result' => $result
                    ]),200);
            }
            return response()->json(
                $this->APIMessage([
                    'code' => 400,
                    'message' => $request->route()->getName()
                ]),400);
        }
    }
    public function delete(Request $request,$id){
        $result = Cinema::find($id);

        if (!is_null($result) && $result->removed == 'N'){
            $result->removed = 'Y';
            $result->save();
            return response()->json(
                $this->APIMessage([
                    'code' => 200,
                    'message' => $request->route()->getName(),
                    'result' => $result
                ]),200);
        }
        return response()->json(
                $this->APIMessage([
                    'code' => 400,
                    'message' => $request->route()->getName()
                ]),400);
    }

    public function show(Request $request,$id){
        $result = Cinema::where('id', $id)->where('removed','N')->get()->toArray();
        return  $result ?
            response()->json(
                $this->APIMessage([
                    'code' => 200,
                    'message' => $request->route()->getName(),
                    'result' => $result
                ]),200) :
            response()->json(
                $this->APIMessage([
                    'code' => 400,
                    'message' => $request->route()->getName()
                ]),400);
    }
}
