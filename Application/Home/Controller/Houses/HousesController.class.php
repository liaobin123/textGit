<?php
namespace Home\Controller\Houses;

use Think\Controller;
use Think\Model;
class HousesController extends Controller{
    private $HousesMode;
    public function __construct(){
        $this->HousesMode=new Model("houses");
    }
    
    /**
     * 加载楼盘信息
     */
    public function laodHousesList($pageNo=1,$pageSize=10){
        //总数量
        $total=$this->HousesMode->count();
        //当前页的数据
        $rows=$this->HousesMode->page($pageNo,$pageSize)->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
    
    /**
     * 收索楼盘信息
     */
    public function selectuse($pageNo=1,$pageSize=10,$searche_name=NULL,$searche_text=null){
        //第一种方法
        $query="1=1 ";
        if($searche_name != null && $searche_name != ""){
            $query .="and name like '%$searche_name%'";
        }
        if($searche_text != null && $searche_text != ""){
            $query .="and price like '%$searche_text%'";
        }
        
        //第二种方法
//         $query=array();
//         if($searche_name != null && $searche_name != ""){
//             $query["name"]=array("LIKE","%$searche_name%");
//         }
//         if($searche_text != null && $searche_text != ""){
//             $query["price"]=array("LIKE","%$searche_text%");
//         }
        
        
        //总数量
        $total=$this->HousesMode->where($query)->count();
        //当前页的数据
        $rows=$this->HousesMode->where($query)->page($pageNo,$pageSize)->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
}

?>