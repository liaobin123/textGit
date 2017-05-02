<?php
namespace Home\Controller\Client;

use Think\Controller;
use Think\Model;
use Home\Controller\tree\TreeNode;
class ClientController extends Controller{
    private $ClientMode;
    public function __construct(){
        parent::__construct();
        $this->ClientMode=M("client");//new Model("client");//D("client");
    }
    
    /**
     * 以树型展示客户
     */
    public function testTree(){
        $eid=$_SESSION["loginUser"]["eid"];
        if($eid !="1"){
            $node1 = new TreeNode();
            $node1->setId(-1);
            $node1->setText("我的客户");
        }else {
            $node1 = new TreeNode();
            $node1->setId(-1);
            $node1->setText("全部客户");
        }
    
        $Clients=$this->ClientMode->where("eid='$eid'")->select();
    
        $children = array();
        foreach ($Clients as $c){
            $node2 = new TreeNode();
            $node2->setId($c["cid"]);
            $node2->setText($c["name"]);
            array_push($children, $node2);
        }
        $node1->children = $children;
        echo "[".json_encode($node1)."]";
    }
    
    /**
     * 加载所有客户信息
     */
    public function loadClient($pageNo=1,$pageSize=10,$eid){
       // $eid=$_SESSION["loginUser"]["eid"];
        if($eid == "1"){
            $clicents=$this->ClientMode->table("client c")->field("c.*")->select();
        }else {
            $clicents=$this->ClientMode->table("employee e,client c")->where("c.eid=e.eid and eid='$eid'")->select();
        }
        echo json_encode($clicents);
    }
    
    /**
     * 点击客户，展示客户相关信息
     */
    public function ClientListByClick(){
        $clientId = $_POST["clientId"];
        $client = $this->ClientMode->table("record r,clicent c,employee e")->field("r.*,c.name,c.phone,c.site,c.level,e.turename")->where("r.cid=c.cid and r.eid=e.eid c.cid='$clientId")->select();
        echo json_encode($client);
    }
    /**
     * 点击客户，展示客户联系信息
     */
    public function loadRecord(){
        $clientId = $_POST["clientId"];
        $client = $this->ClientMode->table("record r,clicent c,employee e")->field("r.*,c.name,c.phone,c.site,c.level,e.turename")->where("r.cid=c.cid and r.eid=e.eid c.cid='$clientId")->select();
        echo json_encode($client);
    }
    
   
}

?>