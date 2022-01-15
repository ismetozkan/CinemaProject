<?php

namespace App\Http\Traits;
use Illuminate\Http\Response;

trait APIMessage
{
    public function APIMessage(string $type,$value, string $message = null){//$result = null,$errors = null
        $code = $value ? 200 : 400;
        switch ($type){
            case 'E':
                $error = $value;
                $status = $code = 400;
                $message = "Lütfen formu eksiksiz bir şekilde doldurunuz.";
                break;
            case 'C':
                $message = $value ?
                    $message . " oluşturma işleminiz başarıyla gerçekleştirilmiştir":
                    $message . " oluşturma işleminiz sırasında bir hata meydana geldi." ;
                break;
            case 'R':
                $message = $value != null ?
                    $message . " görüntüleme işleminiz başarıyla gerçekleştirilmiştir." :
                    "Görüntülenecek veri bulunamadı.";
                break;
            case 'U':
                $message = $value != null ?
                    $message . " update işleminiz başarıyla gerçekleştirilmiştir." :
                    $message .  " update işleminiz sırasında bir hata ile karşılaşıldı.";
                break;
            case 'D':
                $message = $value ?
                    $message . " silme işleminiz başarıyla gerçekleşmiştir." :
                    $message . " silme işleminiz sırasında bir hata ile karşılaşıldı.";
                break;
            default:
                $message = "Hatalı parametre APIMEssage";
                break;
        }

        $json = [
            'code' => $code,
            'message' => $message
        ];

        if(isset($error)){
            $json['error'] = $value;
        }else{
            $value ? $json['code'] = 200 : $json['code'] = 400;
            $status = Response::HTTP_OK;
            $value == null ? :$json['result'] = $value;
        }

        //http status 200 olup code 400 olabilir ?
        return response()->json(
          $json,$status
        );

    }
}
