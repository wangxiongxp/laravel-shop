<?php

namespace App\Services;

use App\Models\SMSCode;
use Flc\Alidayu\App;
use Flc\Alidayu\Client;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class SMSCodeService
{
    public function __construct()
    {
        $this->PrimaryKey = "id";
        $this->TableName  = 'sms_code';
    }

    // 23831383
    // 216797d6adb5306947ce02b4bfd74245
    // 注册验证
    // SMS_67171064
    public function sendSMSCode($tel){

        //短信设置
        $data = array();
        $sysParamService = new SysParamService();
        $item = $sysParamService->getParamByType('alidayu');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }

        $code = rand(100000,999999);

        $config = [
            'app_key' => $data['alidayu_app_key'],
            'app_secret' => $data['alidayu_app_secret']
        ];

        if($data['alidayu_enabled'] == 1){
            $client = new Client(new App($config));
            $req = new AlibabaAliqinFcSmsNumSend();

            $req->setRecNum($tel)
                ->setSmsParam([
                    'code' => $code,
                    'product' => '口述天下'
                ])
                ->setSmsFreeSignName($data['alidayu_sign_name'])
                ->setSmsTemplateCode($data['alidayu_template_code']);

            $return = $client->execute($req);
            if(isset($return->result)){
                return true;
            }
        }
        return false;
    }

    public function updateSMSCode($account_tel,$code){
        $SMSCode = SMSCode::where('account_tel',  $account_tel);
        if($SMSCode){
            $SMSCode->code = $code;
            $SMSCode->save();
        }else{
            $SMSCode = new SMSCode();
            $SMSCode->account_tel = $account_tel;
            $SMSCode->code = $code;
            $SMSCode->save();
        }
    }

    public function getSMSCode($account_tel){
        return SMSCode::where('account_tel',  $account_tel)
            ->whereRaw('now()<=DATE_ADD(updated_at, INTERVAL 1 HOUR)')
            ->first();
    }

}