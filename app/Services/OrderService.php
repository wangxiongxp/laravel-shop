<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;


/**
 * Created by PhpStorm.
 * User: wangxiong
 * Date: 2017/3/28
 * Time: 15:16
 */
class OrderService
{
    public function __construct()
    {
        $this->PrimaryKey = "order_id";
        $this->TableName  = 'order';
    }

    public function queryOrder($arrData)
    {
        $draw       = $arrData['draw'] ;
        $keyword    = $arrData['keyword'] ;

        $length     = $arrData['length'] ;
        $start      = $arrData['start'] ;

        $query = DB::table($this->TableName);
        if(!empty($keyword)){
            $query->where('order_name','like', '%'.$keyword.'%');
        }

        if(!empty($arrData['order_type'])){
            $query->where('order_type','=', $arrData['order_type']);
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

    public function getOrderById($order_id)
    {
        //原生sql操作
        //$order = DB::select("select * from order where order_id = ? ",[$order_id]);

        //查询构造器操作
        //$order = DB::table("order")->where('order_id','=',$order_id)->first();

        //find()查询一条，依据主键查询。findOrFail()查找不存在的记录时会抛出异常
        //$order = Order::find($order_id);

        return Order::where('order_id', '=', $order_id)->first();
    }

    public function insertOrder($arrData)
    {
        //原生SQL，新增成功返回true
        //$bool = DB::insert("insert into order(order_id,order_name,order_email) values(?,?,?)",[1,'小明','xiaoming@qq.com']);

        //查询构造器操作，返回bool值,得到自增ID则，insertGetId
        //$bool = DB::table("order")->insert($arrData);

        //save方法，返回bool值
        //$order = new Order();
        //$order->order_name='张三';
        //$bool = $order->save();

        //以属性查找记录，若没有则新增
        //$order = Order::firstOrCreate(['order_name'=>'张三']);

        //以属性查找记录，若没有则会创建新的实例。若需要保存，则自己调用save方法()
        //$order = Order::firstOrNew(['order_name'=>'张三']);
        //$order->order_email='zhangsan@qq.com';
        //$order->save();

        //create方法,返回order实体
        return Order::create($arrData);
    }

    public function updateOrder($arrData)
    {
        $order_id = $arrData['order_id'];
        //原生SQL，更新成功返回true
        //DB::update('update order set order_name = ? where order_id = ? ',['张三',$order_id]);

        //查询构造器操作，返回bool值
        //DB::table("order")->where('order_id',$order_id)->update($arrData);

        //通过模型更新数据,返回bool值
        //$order = Order::find($order_id);
        //$order->order_name = "张三";
        //$order->save();

        //Order::find($order_id)->update($arrData);

        //通过查询构造器更新,返回更新的行数
        return Order::where('order_id','=',$order_id)->update($arrData);
    }

    public function deleteOrder($order_id)
    {
        //原生sql操作，返回删除的行数
        //DB::delete('delete from order where order_id= ?',[$order_id]);

        //查询构造器操作，返回删除的行数
        //DB::table("order")->where('order_id',$order_id)->delete();

        //根据主键删除，返回删除的行数
        //Order::destroy($order_id);

        //通过模型删除数据，返回bool|null
        //$order = Order::find($order_id)->delete();

        //查询构造器，返回bool|null
        return Order::where('order_id', '=', $order_id)->delete();
    }

    public function updateOrderPassword($order_id,$password)
    {
        return Order::where('order_id','=',$order_id)->update(['password'=>$password]) ;
    }

    public function getExportUser($arrData)
    {
        return Order::all() ;
    }

}