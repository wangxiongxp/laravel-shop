<?php

namespace App\Http\Middleware;

use App\Services\SysParamService;
use Closure;

class ResetConfig
{

    public function handle($request, Closure $next)
    {

        //邮箱设置
        $data = array(); $mail_data = array();
        $sysParamService = new SysParamService();
        $item = $sysParamService->getParamByType('mail');
        for ($i = 0; $i < count($item); $i++) {
            $data[$item[$i]['param_key']] = $item[$i]['param_value'];
        }

        $mail_data['host'] = $data['mail_host'];
        $mail_data['port'] = $data['mail_port'];
        $mail_data['from']['address'] = $data['mail_from_address'];
        $mail_data['from']['name'] = $data['mail_from_name'];
        $mail_data['encryption'] = $data['mail_ssl'];
        $mail_data['username'] = $data['mail_username'];
        $mail_data['password'] = $data['mail_password'];

        config(['mail' => array_merge(config('mail'), $mail_data)]);

        return $next($request);
    }

}
