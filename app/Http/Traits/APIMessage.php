<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

trait APIMessage
{
    public function APIMessage(array $config,array $request = null){
            $result =  [
            'code' => $config['code'],
            'message' => $this->codes([
                'code' => $config['code'],
                'message' => $config['message']
            ])
        ];

        if(isset($config['result'])){
            $result = array_merge($result,[
                'result' => $config['result']
            ]);
        }
        return $result;
    }

    private function codes(array $config){
        $result = [
          'user.read' => [
              200 => 'Giriş işlemi başarılı.',
              400 => 'Beklenmedik bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz'
          ],
            'register.create' => [
                200 => 'Register işlemi başarılı.',
                400 => 'Beklenmedik bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz'
            ],
            'cinema.read' => [
                200 => 'Cinema görüntüleme işlemi başarılı.',
                400 => 'Görüntülenecek veri bulunamadı.'
            ],
            'cinema.create' => [
                201 => 'Cinema oluşturma işlemi başarılı.',
                400 => 'Beklenmedik bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz.'
            ],
            'cinema.show' => [
                200 => 'Cinema görüntüleme işlemi başarılı.',
                400 => 'Görüntülenecek veri bulunamadı'
            ],
            'cinema.update' => [
                200 => 'Cinema update işlemi başarılı.',
                400 => 'Beklenmedik bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz'
            ],
            'cinema.delete' => [
                200 => 'Cinema silme işlemi başarılı.',
                400 => 'Beklenmedik bir hata ile karşılaşıldı. Lütfen tekrar deneyiniz'
            ],
            'validator.error' => [
                400 => 'Lütfen formunuzu eksiksiz bir biçimde doldurunuz'
            ]

        ];

        return $result[$config['message']][$config['code']] ?? 'Tanımlanmamış route name';
        //string yerine $config['message'] yazılabilir. o zaman direkt route adını yazar.

    }
}
