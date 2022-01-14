<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function create(Request $request)
    {


        //deneme
        $rules = [
            'title' => 'required|string',
            'category_id' => 'required|integer',
            'stock' => 'required|integer',
            'price' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            actionLog($request,'E','Lütfen formu eksiksiz doldurun.');

            return [
                'code' => 400,
                'message' => 'Lütfen formu eksiksiz doldurun.',
                'result' => $validator->errors()->messages()
            ];
        }else{
            if(Category::where('id',$request->get('category_id'))->get()->count() == 0)
            {
                actionLog($request,'S','Girmiş olduğunuz kategori sistemde mevcut değildir.Lütfen geçerli bir kategori giriniz.');

                return [
                    'code' => 400,
                    'message' => 'Girmiş olduğunuz kategori sistemde mevcut değildir.Lütfen geçerli bir kategori giriniz.',
                ];
            }else{
                $product = new Product();
                $result = $product::create([
                    'title' => $request->get('title'),
                    'slug' => ronSlug($request->get('title')),
                    'category_id' => $request->get('category_id')
                ]);

                if($result)
                {
                    $product->category()->create([
                        'product_id' => $result->id,
                        'category_id' => $request->get('category_id')
                    ]);
                    $product->detail()->create([
                        'product_id' => $result->id,
                        'price' => $request->get('price'),
                        'stock' => $request->get('stock')
                    ]);
                    $product->store()->create([
                        'store_id' => $request->get('store')->id,
                        'product_id' => $result->id
                    ]);

                    actionLog($request,'S',APIMessage([
                        'route_name' => $request->route()->getName(),
                        'code' => 200
                    ]));

                    return [
                        'code' => 200,
                        'message' => APIMessage([
                            'route_name' => $request->route()->getName(),
                            'code' => 200
                        ]),
                        'result' => $result,
                        'token' => tokenUpdate($request)
                    ];
                }else{
                    actionLog($request,'S',APIMessage([
                        'route_name' => $request->route()->getName(),
                        'code' => 400
                    ]));

                    return [
                        'code' => 400,
                        'message' => APIMessage([
                            'route_name' => $request->route()->getName(),
                            'code' => 400
                        ]),
                    ];
                }
            }
        }
    }
}
