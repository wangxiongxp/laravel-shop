<?php

namespace App\Services;

use App\Models\RoleMember;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class RoleMemberService
{
    protected $roleMemberRepository;

    public function __construct()
    {
//        $this->PrimaryKey = "s_role_id";
        $this->TableName  = 's_role_member';
    }

    public function queryRoleMember($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName)
            ->leftJoin('s_role','s_role.s_role_id', '=', 's_role_member.s_role_id')
            ->leftJoin('account','s_role_member.account_id', '=', 'account.account_id')
            ->select('s_role_member.*','s_role.s_role_name','account.account_real_name');

        if(!empty($keyword)){
            $query->where('s_role.s_role_name','like', '%'.$keyword.'%');
        }
        if(isset($arrData['s_role_id'])){
            $query->where('s_role_member.s_role_id','=', $arrData['s_role_id'] );
        }

        $sum = $query->count();

        if(isset($arrData['orderBy'])){
            $arrSort = explode('.', $arrData['orderBy']);
            $query->orderBy($arrSort[0], $arrSort[1]);
        }

        if($sum > 0){
            $rows = $query->skip($start)->take($length)->get();
        }else{
            $rows = array();
        }

        //当前第几页
        $start = intval($start) + 1 ;
        if($start % $length == 0){
            $page = $start / $length ;
        }else{
            $page = $start / $length + 1 ;
        }

        $resultData = array();
        $resultData['draw']            = $draw ;
        $resultData['page']            = intval($page);//当前第几页
        $resultData['recordsTotal']    = $sum ;//总数量
        $resultData['recordsFiltered'] = $sum ;
        $resultData['items']           = $rows ;//数据

        return $resultData ;
    }

    public function insertRoleMember($arrData)
    {
        $s_role_id  = $arrData['s_role_id'];
        $account_id = $arrData['account_id'];

        $accountArr = explode("_",$account_id);

        $data = array();
        $data['s_role_id'] = $s_role_id;
        foreach ($accountArr as $item) {
            $data['account_id'] = $item;
            RoleMember::create($data);
        }
        return true;
    }

    public function deleteRoleMember($s_role_id, $account_id)
    {
        return RoleMember::where('s_role_id', '=', $s_role_id)
            ->where('account_id', '=', $account_id)->delete();
    }

    public function getAccountRoles($account_id)
    {
        return DB::select('select DISTINCT b.* from s_role_member as a
              left join s_role as b on a.s_role_id = b.s_role_id
              where a.account_id = ?', array($account_id));
    }

}