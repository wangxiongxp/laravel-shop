<?php

namespace App\Services;

use App\Models\UserAddress;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class UserAddressService
{
    public function __construct()
    {
        $this->PrimaryKey = "address_id";
        $this->TableName  = 'user_address';
    }

    public function getUserAddressByAccountId($account_id)
    {
        return UserAddress::where('account_id', '=', $account_id)->get();
    }

    public function setDefault($account_id,$address_id)
    {
        UserAddress::where('account_id', '=', $account_id)->update(['is_default'=>0]);
        UserAddress::where('address_id', '=', $address_id)->update(['is_default'=>1]);

        return true;
    }



    public function getUserAddressById($address_id)
    {
        return UserAddress::where('address_id', '=', $address_id)->first();
    }

    public function insertUserAddress($arrData)
    {
        return UserAddress::create($arrData);
    }

    public function updateAdItem($arrData)
    {
        $account_id = $arrData['account_id'];
        return UserAddress::where('account_id','=',$account_id)->update($arrData);
    }

    public function deleteAdItem($account_id)
    {
        return UserAddress::where('account_id', '=', $account_id)->delete();
    }

}