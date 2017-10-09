<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Account;
use App\Services\AccountService;
use App\Services\SMSCodeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sys_account_tel' => 'required|mobile|size:11|unique:account,sys_account_tel',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Account
     */
    protected function create(array $data)
    {
        /*
        return Account::create([
            'sys_account_name' => $data['sys_account_tel'],
            'sys_account_tel'  => $data['sys_account_tel'],
            'password' => bcrypt($data['password']),
            'remember_token' => ''
        ]);
        */
        $ins = [
            'sys_account_tel'  => $data['sys_account_tel'],
            'password' => bcrypt($data['password'])
        ];
        $AccountService = new AccountService();
        $AccountService->createAccountM($ins);

        return Account::where('sys_account_tel', '=', $data['sys_account_tel'])->first();
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return 'sys_account_name';
    }

    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

//        $this->guard()->login($user);
//
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
        return redirect('/admin/login');
    }

}
