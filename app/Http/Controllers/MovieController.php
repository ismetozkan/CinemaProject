<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    use APIMessage;

    public function read(){
        $result = Movie::all()->toArray();
        return $this->APIMessage('R',$result,'Filmler');
    }

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return $this->APIMessage('E',$validator->errors()->messages());
        }else{
            $movie = new Movie();
            $result = $movie::create([
                'title' => $request->title
            ]);
            return $this->APIMessage('C',$result,'Film');
        }
    }

    public function delete($id)
    {
        $result = Movie::where('id', $id)->update([
            'removed' => 'Y'
        ]);
        return $this->APIMessage('D',$result,'Film');
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
            return $this->APIMessage('E',$validator->errors()->messages());

        }else{
            $result = Movie::find($id);

            if (!is_null($result)){
                $result->title = $request->get('title') ? $request->get('title')  : $result->title;
                $result->save();
            }

            return $this->APIMessage('U',$result,'Film');
        }
    }

    public function show($id)
    {
        $result = Movie::where('id', $id)->where('removed','N')->get()->toArray();
        return $this->APIMessage('R',$result,'Film');
    }
}
