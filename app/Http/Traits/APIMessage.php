<?php

namespace App\Http\Traits;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Response;

trait APIMessage
{
    public function APIMessage(string $type,$value, string $message = null){//$result = null,$errors = null
        switch ($type){
            case 'E':
                $error = $value;
                $message = "Lütfen formu eksiksiz bir şekilde doldurunuz.";
                break;
            case 'C':
                $message = $value ?
                    $message . " oluşturma işleminiz başarıyla gerçekleştirilmiştir":
                    $message . " oluşturma işleminiz sırasında bir hata meydana geldi." ;
                break;
            case 'D':
                $message = $value ?
                    $message . " silme işleminiz başarıyla gerçekleşmiştir." :
                    $message . " silme işleminiz sırasında bir hata ile karşılaşıldı.";
                break;
            case 'U':
                $message = $value != null ?
                    $message . " update işleminiz başarıyla gerçekleştirilmiştir." :
                    $message .  " update işleminiz sırasında bir hata ile karşılaşıldı.";
                break;
            case 'R':
                $message = $value != null ?
                    $message . " görüntüleme işleminiz başarıyla gerçekleştirilmiştir." :
                    "Görüntülenecek veri bulunamadı.";
                break;
        }

        if($type == 'E'){
            return response()->json([
                'code' => 400,
                'message' => "Lütfen formu eksiksiz bir şekilde doldurunuz.",
                'error' => $value
            ],Response::HTTP_BAD_REQUEST);
        }

        $code = $value ? 200 : 400;

        return $value ? response()->json([
            'code' => $code,
            'message' => $message,
            ($type != 'U' && $type != 'D') ?  :'result' => $value,
            $error == null ? : 'error' => $error
        ],Response::HTTP_OK) :
            response()->json([
                'code' => $code,
                'message' => $message
            ],Response::HTTP_BAD_REQUEST);

    }
}
