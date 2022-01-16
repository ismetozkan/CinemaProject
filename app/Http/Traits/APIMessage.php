<?php

namespace App\Http\Traits;

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
        $route_name = explode('.',$config['message']);
        $route = [
            'cinema' => 'Sinema salonu',
            'movies' => 'Film',
            'salons' => 'Salon',
            'cnmtomovie' => 'Sinema Film ilişkisi',
            'showings' => 'Gösterim',
            'seats' => 'Koltuk',
            'tickets' => 'Bilet',
            'user' => 'Kullanıcı'
        ];
        if($route_name[1] == 'create'){
            $value = [
                201 => $route[$route_name[0]] ." oluşturma işlemi başarılı",
                400 => $route[$route_name[0]] .' oluşturma işlemi başarısız'
            ];
        }elseif($route_name[1] == 'update'){
            $value = [
                200 => $route[$route_name[0]] ." güncelleme işlemi başarılı",
                400 => $route[$route_name[0]] .' güncelleme işlemi başarısız'
            ];
        }elseif($route_name[1] == 'read' || $route_name[1] == 'show'){
            $value = [
                200 => $route[$route_name[0]] . " gösterme işlemi başarılı",
                400 => $route[$route_name[0]] . ' gösterme işlemi başarısız'
            ];
        }elseif($route_name[1] == 'delete'){
            $value = [
                200 => $route[$route_name[0]]." silme işlemi başarılı",
                400 => $route[$route_name[0]] .' silme işlemi başarısız'
            ];
        }else{
            $value = [
                $config['code'] => $config['message']
            ];
        }
        return  $value[$config['code']];
    }

}
