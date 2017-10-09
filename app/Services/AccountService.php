<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class AccountService
{
    public function __construct()
    {
        $this->PrimaryKey = "account_id";
        $this->TableName  = 'account';
    }

    public function queryAccount($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('account_name','like', '%'.$keyword.'%');
        }

        if(!empty($arrData['account_type'])){
            $query->where('account_type','=', $arrData['account_type']);
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

    public function getAccountById($account_id)
    {
        //原生sql操作
        //$account = DB::select("select * from account where account_id = ? ",[$account_id]);

        //查询构造器操作
        //$account = DB::table("account")->where('account_id','=',$account_id)->first();

        //find()查询一条，依据主键查询。findOrFail()查找不存在的记录时会抛出异常
        //$account = Account::find($account_id);

        return Account::where('account_id', '=', $account_id)->first();
    }

    public function insertAccount($arrData)
    {
        //原生SQL，新增成功返回true
        //$bool = DB::insert("insert into account(account_id,account_name,account_email) values(?,?,?)",[1,'小明','xiaoming@qq.com']);

        //查询构造器操作，返回bool值,得到自增ID则，insertGetId
        //$bool = DB::table("account")->insert($arrData);

        //save方法，返回bool值
        //$account = new Account();
        //$account->account_name='张三';
        //$bool = $account->save();

        //以属性查找记录，若没有则新增
        //$account = Account::firstOrCreate(['account_name'=>'张三']);

        //以属性查找记录，若没有则会创建新的实例。若需要保存，则自己调用save方法()
        //$account = Account::firstOrNew(['account_name'=>'张三']);
        //$account->account_email='zhangsan@qq.com';
        //$account->save();

        //create方法,返回account实体
        return Account::create($arrData);
    }

    public function updateAccount($arrData)
    {
        $account_id = $arrData['account_id'];
        //原生SQL，更新成功返回true
        //DB::update('update account set account_name = ? where account_id = ? ',['张三',$account_id]);

        //查询构造器操作，返回bool值
        //DB::table("account")->where('account_id',$account_id)->update($arrData);

        //通过模型更新数据,返回bool值
        //$account = Account::find($account_id);
        //$account->account_name = "张三";
        //$account->save();

        //Account::find($account_id)->update($arrData);

        //通过查询构造器更新,返回更新的行数
        return Account::where('account_id','=',$account_id)->update($arrData);
    }

    public function deleteAccount($account_id)
    {
        //原生sql操作，返回删除的行数
        //DB::delete('delete from account where account_id= ?',[$account_id]);

        //查询构造器操作，返回删除的行数
        //DB::table("account")->where('account_id',$account_id)->delete();

        //根据主键删除，返回删除的行数
        //Account::destroy($account_id);

        //通过模型删除数据，返回bool|null
        //$account = Account::find($account_id)->delete();

        //查询构造器，返回bool|null
        return Account::where('account_id', '=', $account_id)->delete();
    }

    public function updateAccountPassword($account_id,$password)
    {
        return Account::where('account_id','=',$account_id)->update(['password'=>$password]) ;
    }

    public function getExportUser($arrData)
    {
        return Account::all() ;
    }

}