<?php
namespace Home\Controller\Complain;

use Think\Controller;
use Think\Model;
class ComplainController extends Controller{
    private $ComplainMode;
    public function __construct(){
        $this->ComplainMode=new Model("Complain");
    }
    /**
     * 加载投诉信息
     * @param number $pageNo
     * @param number $pageSize
     */
    public function LaodComplainList($pageNo=1,$pageSize=3){
        //总数量
        $total=$this->ComplainMode->count();
        //当前页的数据
        $rows=$this->ComplainMode->page($pageNo,$pageSize)->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->ajaxReturn($page);
    }
    
}

?>