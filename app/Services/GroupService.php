<?php

namespace App\Services;

use App\Models\Group;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class GroupService
{
    public function __construct()
    {
        $this->PrimaryKey = "s_group_id";
        $this->TableName  = 's_group';
    }

    public function getGroupById($s_group_id)
    {
        return Group::leftJoin('s_group as parent','s_group.s_group_parent', '=', 'parent.s_group_id')
            ->leftJoin('s_group_type','s_group_type.s_group_type_id', '=', 's_group.s_group_type_id')
            ->select('s_group.*','parent.s_group_name as s_group_parent_name','s_group_type.s_group_type_name')
            ->where('s_group.s_group_id', '=', $s_group_id)->first();
    }

    public function insertGroup($arrData)
    {
        $group = Group::where('s_group_id', '=', $arrData['s_group_parent'])
            ->first();

        $s_group_right = $group->s_group_right;
        $s_group_left  = $group->s_group_left;


        Group::where('s_group_right','>=', $s_group_right)
            ->increment('s_group_right', 2);

        Group::where('s_group_left','>=', $s_group_right)
            ->increment('s_group_left', 2);

        $group_data = array();
        $group_data['s_group_name']     = $arrData['s_group_name'];
        $group_data['s_group_type_id']  = $arrData['s_group_type_id'] ;
        $group_data['s_group_desc']     = isset($arrData['s_group_desc'])?$arrData['s_group_desc']:'' ;
        $group_data['s_group_left']     = intval($s_group_right);
        $group_data['s_group_right']    = intval($s_group_right) + 1;
        $group_data['s_group_parent']   = $arrData['s_group_parent'];
        $group_data['s_group_level']    = $group->s_group_level + 1;
        $group_data['s_group_leaf']     = 1 ;

        Group::create($group_data);

        if($group->s_group_leaf == 1){
            Group::where('s_group_id','=',$arrData['s_group_parent'])->update(["s_group_leaf"=>0]);
        }

        return true;
    }

    public function updateGroup($arrData)
    {
        $s_group_id = $arrData['s_group_id'];
        return Group::where('s_group_id','=',$s_group_id)->update($arrData);
    }

    public function deleteGroup($s_group_id)
    {
        $group = Group::where('s_group_id', '=', $s_group_id)
            ->first();

        $s_group_right = $group->s_group_right;
        $s_group_left  = $group->s_group_left;

        Group::where('s_group_left', '>=' , $s_group_left)
            ->where('s_group_right', '<=' , $s_group_right)
            ->delete();

        $steps = $s_group_right - $s_group_left + 1 ;
        Group::where('s_group_left','>', $s_group_left)
            ->decrement('s_group_left', $steps);

        Group::where('s_group_right','>', $s_group_right)
            ->decrement('s_group_right', $steps);

        $count = Group::where('s_group_parent', '=', $group->s_group_parent)->count();
        if($count < 1){
            Group::where('s_group_id', '=', $group->s_group_parent)
                ->update(['s_group_leaf' => 1]);
        }
        return true;
    }

    public function getGroupTree($s_group_parent)
    {
        $root = Group::where('s_group_parent', '=', $s_group_parent)->get();

        $arrResult = array();

        $arrSub = array();
        $opened = array();
        $opened['opened'] = true;
        if(count($root)>0){
            foreach($root as $item)
            {
                unset($arrSub);
                $arrSub['id']    = $item->s_group_id;
                $arrSub['text']  = $item->s_group_name;
                $arrSub['state']  = $opened;
                $arrSub['children'] = $this->getGroupTree($item->s_group_id);

                $arrResult[] = $arrSub;
            }
        }

        return $arrResult;

    }


}