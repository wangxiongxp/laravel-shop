<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Utils;
use App\Models\Account;
use App\Services\LoginLogService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $account_id = $user->account_id;

        //保存登录记录
        $logData = array();
        $logData['account_id'] = $account_id;
        $logData['login_time'] = Utils::GetDatetimeWithUTC();
        $logData['login_ip']   = Utils::GetIP();
        $logLoginService = new LoginLogService();
        $logLoginService->insertLoginLog($logData);

        //更新最后一次登录记录
        $arrData = array();
        $arrData['account_last_login'] = $logData['login_time'];
        $arrData['account_last_ip']    = $logData['login_ip'];
        Account::where('account_id','=',$account_id)->update($arrData);

        return redirect()->intended($this->redirectPath());
    }

    public function showLoginForm()
    {
        return view('web.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function username()
    {
        return 'account_name';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }

}
