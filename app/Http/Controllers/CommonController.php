<?php

namespace App\Http\Controllers;

use App\Services\SMSCodeService;
use Illuminate\Http\Response;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class CommonController extends Controller
{
    /**
     * 发送短信验证码
     */
    public function sendSMSCode($tel){

        // 配置信息
        $config = [
            'app_key'    => env("Alidayu_App_Key"),
            'app_secret' => env("Alidayu_App_Secret"),
        ];

        $data = array();
        $data['code'] =	rand(100000,999999);
        if(env('Alidayu_Enabled') == '1'){

            $client = new Client(new App($config));
            $req    = new AlibabaAliqinFcSmsNumSend;

            $req->setRecNum($tel)
                ->setSmsParam([
                    'number' => $data['code']
                ])
                ->setSmsFreeSignName(env("Alidayu_Sign_Name"))
                ->setSmsTemplateCode(env("Alidayu_Sms_TemplateCode"));

            $resp = $client->execute($req);

            if($resp->result && $resp->result->success){
                $SMSCodeService =   new SMSCodeService();
                $SMSCodeService->updateSMSCode($tel,$data['code']);
                return response()->json(array(), Response::HTTP_OK);
            }else{
                return response()->json(array(), Response::HTTP_BAD_REQUEST);
            }
        }else{

            $SMSCodeService = new SMSCodeService();
            $SMSCodeService->updateSMSCode($tel,$data['code']);
            return response()->json($data, Response::HTTP_OK);
        }

    }


//    public function sendSMSCode($tel)
//    {
//        $data = array();
//        $data['code'] =	rand(100000,999999);
//        if(env('Alidayu_Enabled') == '1'){
//            $c = new \TopClient();
//            $c->appkey = env("Alidayu_App_Key");
//            $c->secretKey = env("Alidayu_App_Secret");
//            $c->format = 'json';
//
//            $req = new \AlibabaAliqinFcSmsNumSendRequest();
//            $req->setExtend($tel);
//            $req->setSmsType("normal");
//            $req->setSmsFreeSignName(env("Alidayu_Sign_Name"));
//            $req->setSmsParam("{\"code\":\"".$data['code']."\"}");
//            $req->setRecNum($tel);
//            $req->setSmsTemplateCode(env("Alidayu_Sms_Code_TemplateCode"));
//            $resp = $c->execute($req);
//
//            if($resp->result && $resp->result->success){
//                $SMSCodeService =   new SMSCodeService();
//                $SMSCodeService->updateSMSCode($tel,$data['code']);
//                return response()->json(array(), Response::HTTP_OK);
//            }else{
//                return response()->json(array(), Response::HTTP_BAD_REQUEST);
//            }
//
//        }else{
//
//            $SMSCodeService =   new SMSCodeService();
//            $SMSCodeService->updateSMSCode($tel,$data['code']);
//            return response()->json($data, Response::HTTP_OK);
//
//        }
//        return $this->showJsonResult(true, '发送成功', null);
//    }


}
