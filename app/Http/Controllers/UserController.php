<?php

namespace App\Http\Controllers;

use App\Models\CinemaToMovie;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{


    public function read()
    {
    
        /*return view('booking', [
            'users' => User::get()
        ]);*/
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'message' => $validator->errors()->messages()
            ], Response::HTTP_BAD_REQUEST );
        } else {
            $result = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return response()->json([
                'code' => $result ? '200' : '400',
                'message' => $result
                    ? 'Başarılı'
                    : 'Başarısız',
            ], $result
                ? '200'
                : '400');
        }
    }

    public function update(Request $request,$id){
        User::where('id', $id)->update($request->all());
        return response()->json([
            'result' => 'true'
        ]);
    }

    public function login(Request $request)
    {
        $auth = User::all()->where('email',$request->get('email'))->where('where',$request->get('password'));

        return $auth->count() > 0
            ? response()->json([
                'code' => 200,
                'message' => 'Giriş işleminiz başarılıdır.',
                'result' => $auth->first()->remember_token
            ],Response::HTTP_OK)
            : response()->json([
                'code' => 400,
                'message' => 'Giriş işleminiz hatalı.',
            ],Response::HTTP_BAD_REQUEST);
    }

    public function delete(Request $request,$id)
    {
        $result=User::where('id',$id)->update([
            'removed'=>'Y'

        ]);

        return response()->json([
            'code' => $result  ? '200' : '400',
            'message' => $result
                ? 'Başarılı'
                : 'Başarısız',
        ],$result  ? '200' : '400');

    }

}
