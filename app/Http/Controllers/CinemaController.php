<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CinemaController extends Controller
{
    use APIMessage;
    public function read(){
        $result = Cinema::all()->toArray();
        return $this->APIMessage('R',$result,'Sinema Salonları');

    }

    public function create(Request $request){
        $rules = [
            'title' => 'required|string',
            'location' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return $this->APIMessage('E',$validator->errors()->messages());
        }else{
            $cinema = new Cinema();
            $result = $cinema::create([
                'title' => $request->title,
                'location' => $request->location
            ]);

            return $this->APIMessage('C',$result,'Sinema Salonu');
        }
    }

    public function delete($id){
        $result = Cinema::where('id', $id)->update([
            'removed' => 'Y'
        ]);
        return $this->APIMessage('D',$result,'Sinema Salonu');
    }

    public function update(Request $request,$id){
        $result = Cinema::where('id', $id)->update($request->all());
        return $this->APIMessage('U',$result,'Sinema Salonu');
    }

    public function show(Request $request,$id){
        $result = Cinema::where('id', $id)->where('removed','N')->get()->toArray();
        return $this->APIMessage('R',$result,'Sinema Salonu');
    }
}
