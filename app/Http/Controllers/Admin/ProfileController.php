<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProfileController extends Controller  {

	public function index(){
	    $data = [];
	    $userInfo = Auth::user();
        $AccountService = new AccountService();
        $accountInfo    = $AccountService->getAccountById($userInfo->account_id);
        if($accountInfo) {
            $data['account'] = $accountInfo;
        }
		return view('admin/profile/index', $data);
	}

//	public function updateProfile(Request $request)
//    {
//        $rules = [
//            'sys_account_email' => 'required|email'
//        ];
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails()) {
//            return $this->showJsonMessage(false, $validator->errors()->all());
//        }
//        $userInfo = Auth::user();
//        $request['sys_account_id'] = $userInfo->sys_account_id;
//        $AccountService = new AccountService();
//        $AccountService->updateAccount($request->all());
//        return $this->showJsonMessage(true);
//    }
//
//    public function updateUserPhoto(Request $request)
//    {
//        $file = $request->file('userPhoto');
//        if(!$file) {
//            return $this->showJsonMessage(false, ['上传文件为空']);
//        }
//        if(!$file->isValid()) {
//            return $this->showJsonMessage(false, ['上传文件无效']);
//        }
//        $allowed_extensions = ["png", "jpg", "gif"];
//        $extension  = $file->getClientOriginalExtension();
//        if ($extension && !in_array($extension, $allowed_extensions)) {
//            return $this->showJsonMessage(false, ['上传文件格式不正确, 当前支持png/jpg/gif格式']);
//        }
//        $destinationPath = 'upload/user_photo/';
//        if(!file_exists($destinationPath)) {
//            mkdir($destinationPath, 0777, true);
//        }
//        $fileName = str_random(10).'.'.$extension;
//        $file->move($destinationPath, $fileName);
//
//        $path = '/'.$destinationPath.$fileName;
//        $userInfo = Auth::user();
//        $ins = [
//            'sys_account_id' => $userInfo->sys_account_id,
//            'sys_account_pic' => $path
//        ];
//        $AccountService = new AccountService();
//        $AccountService->updateAccount($ins);
//        return $this->showJsonMessage(true,[], ['path'=> $path]);
//    }


}