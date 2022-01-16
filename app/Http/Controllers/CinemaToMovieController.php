<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\CinemaToMovie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CinemaToMovieController extends Controller
{
    use APIMessage;
    public function read(){
        $result = CinemaToMovie::all()->where('showings','Y')->toArray();
        return $this->APIMessage('R',$result,'Sinema Salonu Film İlişkisi');
    }

    public function create(Request $request)
    {
        $rules = [
            'cinema_id' => 'required|integer',
            'movie_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return $this->APIMessage('E',$validator->errors()->messages());
        }else{
            try {
                $cinemaToMovie = new CinemaToMovie();
                $result = $cinemaToMovie::create([
                    'cinema_id' => $request->cinema_id,
                    'movie_id' => $request->movie_id,
                    'start' => $request->start,
                    'end' => $request->end
                ]);
            }catch (\Exception $e){
                return $this->APIMessage('E',$e->getMessage());
            }
            return $this->APIMessage('C',$result,'Sinema Salonu Film İlişkisi');
        }
    }

    public function delete($id){
        $result = CinemaToMovie::find($id);
        if (!is_null($result) && $result->showings != 'N'){
            $result->showings = 'N';
            $result->save();
            return $this->APIMessage('D',$result,'Sinema Salonu Film İlişkisi');
        }
        return $this->APIMessage('D',null,'Sinema Salonu Film İlişkisi');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'cinema_id' => 'nullable|integer',
            'movie_id' => 'nullable|integer',
            'start' => 'nullable|date',
            'end' => 'nullable|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails())
        {
            return $this->APIMessage('E',$validator->errors()->messages());

        }else{
        $result = CinemaToMovie::find( $id);
        if (!is_null($result) && $result->removed != 'N'){
            $result->cinema_id = $request->get('cinema_id') ? $request->get('cinema_id')  : $result->cinema_id;
            $result->movie_id = $request->get('movie_id') ? $request->get('movie_id')  : $result->movie_id;
            $result->start = $request->get('start') ? $request->get('start')  : $result->start;
            $result->end = $request->get('end') ? $request->get('end')  : $result->end;
            $result->save();

            return $this->APIMessage('U',$result,'Sinema Salonu Film İlişkisi');
        }
        return $this->APIMessage('U',null,'Sinema Salonu Film İlişkisi');
        }
    }

    public function show($id){
        $result = CinemaToMovie::where('id', $id)->where('showings','Y')->get()->toArray();
        return $this->APIMessage('R',$result,'Sinema Salonu Film İlişkisi');
    }
}
