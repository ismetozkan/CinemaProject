<?php

namespace App\Http\Controllers;

use App\Http\Traits\APIMessage;
use App\Models\CinemaToMovie;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use APIMessage;

    public function read(Request $request){
        $filter = $request->get('type');
        $result = User::all()
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
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($this->APIMessage([
                'code' => 400,
                'message' => 'Formu eksiksiz bir şekilde doldurunuz.',
                'result' => $validator->errors()
            ]),400);
        } else {
            $result = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
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
