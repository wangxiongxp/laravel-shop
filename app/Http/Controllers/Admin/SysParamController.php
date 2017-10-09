<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\SMSCodeService;
use App\Services\SysParamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SysParamController extends Controller
{
    protected $sysParamService;

    public function __construct(SysParamService $sysParamService)
    {
        $this->middleware('auth');
        $this->sysParamService = $sysParamService;
    }

    public function website()
    {
        $data = array();
        //站点信息
        $item = $this->sysParamService->getParamByType('website');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }
        //邮箱设置
        $item = $this->sysParamService->getParamByType('mail');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }
        //短信设置
        $item = $this->sysParamService->getParamByType('alidayu');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }

        return view('admin/sysParam/website',$data);
    }

    public function saveParam()
    {
        $this->sysParamService->saveParam();
        return $this->showJsonResult(true, '保存成功', null);
    }

    public function sendEmail()
    {
        $data = array();
        $item = $this->sysParamService->getParamByType('mail');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }

        Mail::raw("恭喜你，邮件发送成功！", function ($message) use ($data){
            $message->subject('测试邮件发送' .date('Y-m-d H:i:s'));
            $message->to($data['mail_admin_email']);
        });

        return $this->showJsonResult(true, '发送成功', null);
    }

    public function sendMessage($tel)
    {
        $SMSCodeService = new SMSCodeService();
        $return = $SMSCodeService->sendSMSCode($tel);
        if($return){
            return $this->showJsonResult($return, '发送成功', null);
        }else{
            return $this->showJsonResult($return, '发送失败', null);
        }

    }

}
