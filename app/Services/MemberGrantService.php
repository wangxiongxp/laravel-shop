<?php

namespace App\Services;

use App\Models\Group;
use App\Models\MemberGrant;

/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class MemberGrantService
{
    public function __construct()
    {
        $this->PrimaryKey = "account_id";
        $this->TableName  = 's_member_grant';
    }

    public function deleteMemberGrant($account_id)
    {
        return MemberGrant::where('account_id', '=', $account_id)->delete();
    }

    public function insertMemberGrant($arrData)
    {
        return MemberGrant::create($arrData);
    }

    public function getSelectedGroupTree($account_id)
    {
        $rows = MemberGrant::where('account_id', '=', $account_id)->get();
        $group_array = [];
        foreach ($rows as $row) {
            $group_array[] = $row->s_group_id;
        }
        $arrResult  = $this->GetGroupList($group_array,0);

        return $arrResult;
    }

    public function GetGroupList($group_array,$s_group_parent)
    {
        $arrResult = array();
        $root      = Group::where('s_group_parent', '=', $s_group_parent)->get();

        $arrSub    = array();
        foreach($root as $item)
        {
            unset($arrSub);

            $selected = false;
            if(in_array($item->s_group_id,$group_array)){
                $selected = true;
            }
            $arrSub['id']    = $item->s_group_id;
            $arrSub['text']  = $item->s_group_name;
            $arrSub['state']    = array('opened'=>true,'selected'=>$selected);
            $arrSub['children'] = $this->GetGroupList($group_array,$item->s_group_id);

            $arrResult[] = $arrSub;
        }

        return $arrResult;
    }


}