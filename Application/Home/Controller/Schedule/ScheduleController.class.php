<?php
namespace Home\Controller\Schedule;

use Think\Controller;
use Think\Model;
class ScheduleController extends Controller{
    private $ScheduleMode;
    public function __construct(){
        $this->ScheduleMode=new Model("schedule");
    }
    /**
     * 加载日程信息
     */
    public function laodScheduleList($pageNo=1,$pageSize=10){
        //总数量
        $total=$this->ScheduleMode->count();
        //当前页的数据
        $rows=$this->ScheduleMode->page($pageNo,$pageSize)->table("employee e,schedule s")->field("e.turename,s.time,s.plan,s.sid")->order("sid desc")->where("s.employeeID=e.eid")->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
    
    /**
     * 收索员工日程信息
     */
    public function selectuse($pageNo=1,$pageSize=10,$searche_text=null){
//         //第一种方法
        $query="1=1 ";
        if($searche_text != null && $searche_text != ""){
            $query .="and e.turename like '%$searche_text%'";
        }
    
//第二种方法
//         $query=array();
//         if($searche_text != null && $searche_text != ""){
//             $query["turename"]=array("LIKE","%$searche_text%");
//         }
    
    
        //总数量
        $total=$this->ScheduleMode->table("employee e,schedule s")->field("e.turename,s.time,s.plan,s.sid")->where("s.employeeID=e.eid")->where($query)->count();
        //当前页的数据
        $rows=$this->ScheduleMode->table("employee e,schedule s")->field("e.turename,s.time,s.plan,s.sid")->where("s.employeeID=e.eid")->where($query)->page($pageNo,$pageSize)->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
    /**
     * 添加日程
     */
    public function addSchedule(){
        $data=$this->ScheduleMode->create();//获得传来的数据创建为对象
        $data["employeeID"]=$_SESSION["loginUser"]["eid"];
        $this->ScheduleMode->field("time,plan,employeeID")->add($data);
        $this->laodScheduleList();//调用加载日程信息函数
    }
    
    /**
     * 删除日程
     */
    public  function deleteHousesList($rowsdata){
        $row=0;
        for($i=0;$i<count($rowsdata);$i++){
             $row +=$this->ScheduleMode->delete($rowsdata[0][$i]["sid"]);//删除数据
        }
        echo $row;
        //$this->ajaxReturn($row);
    }
}

?>