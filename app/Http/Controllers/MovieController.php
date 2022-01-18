<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    use APIMessage;

    public function read(Request $request){
        $filter = $request->get('type');
        $result = Movie::all()
            ->when($filter, function ($query, $filter) {
                return $query->where('removed', $filter);
            })->toArray();

        return response()->json($this->APIMessage([
            'code' => $result ? 200 : 400,
            'message' => $request->route()->getName(),
            'result' => $result
        ]),$result ? 200 : 400);
    }

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string'
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
            $movie = new Movie();
            $result = $movie::create([
                'title' => $request->title
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

    public function delete(Request $request,$id)
    {
        $result = Movie::find($id);

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

    public function update(Request $request, $id)
    {
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
        }
        else{
            $result = Movie::find($id);

            if (!is_null($result) && $result->removed == 'N'){
                $result->title = $request->get('title') ? $request->get('title')  : $result->title;
                $result->save();
                return $this->APIMessage('U',$result,'Film');
            }

            return $this->APIMessage('U',null,'Film');
        }
    }

    public function show(Request $request,$id)
    {
        $result = Movie::where('id', $id)->where('removed','N')->get()->toArray();
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
