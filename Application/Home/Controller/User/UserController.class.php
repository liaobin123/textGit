<?php
namespace Home\Controller\User;

use Think\Controller;
use Think\Model;
use Home\Controller\tree\TreeNode;
class UserController extends Controller{
    
    private $UserMode;
    private $data;
    
    public function __construct(){
        parent::__construct();
        $this->UserMode = new Model("employee");
        $this->ClientMode=new Model("client");//M("client");
    }
    
    /**
     * 用户登录
     */
    public function login($employee,$pass){
        //echo "$employee,$pass";
//         $employee=$_POST["employee"];//获得输入的帐号（这里的name要和表单帐号的input的name相同）
//         $pass=$_POST["pass"];//获得输入的密码（这里的pass要和表单密码的input的name相同）
        $users = $this->UserMode->where("number='$employee'")->select();
        if(count($users)> 0){
            //用户存在
            $u = $users[0];
            if($pass == $u[pass]){
                //密码正确
                $_SESSION["loginUser"]=$u;
                //查询用户拥有的菜单
                $menus=$this->UserMode->table("employeejob ej,jobmenu jm,menu m")
                ->field("m.*")->where("ej.jid=jm.jid and jm.mid=m.mid and ej.eid=".$u[eid])->select();
                $_SESSION["menus"]=$menus;
                
                $this->assign("url",BASEPATH);//保存绝对路径方便页面使用 
                $this->display("ezuiWelcome");
//                 $url=BASEPATH."/ezuiWelcome.php";
//                 header("location:$url");
            }else {
                //密码错误
                $_SESSION["loginErro"]="对不起，您输入密码错误";
                $url=BASEPATH."/login.php";
                header("location:$url");
            }
            
        }else {
            //用户不存在
            $_SESSION["loginErro"]="对不起，您输入帐号不存在";
            $url=BASEPATH."/login.php";
            header("location:$url");
        }
    }
    
    /**
     * 用户注册
     */
    public function reg(){
        //获取表单传来的数据
        $tureName=$_POST["tureName"];
        $pass=$_POST["pass"];
        $phone=$_POST["phone"];
        $number=$_POST["number"];
        
       $users=$this->UserMode->where("number=".$number)->select();//通过输入帐号到数据库查找数据
       if(count($users) > 0){//如果有数据那么表示已被注册，不能在注册
            $_SESSION["regErro"]="对不起该账户已被注册";
            $url=BASEPATH."/reg.php";
            header("location:$url");
       }else {//可以注册
           $array=array(
               "number"=>$number,
               "pass"=>$pass,
               "phone"=>$phone,
               "turename"=>$tureName
           );
           $this->UserMode->add($array);
           $_SESSION["reg"]="注册成功,请登录";
           $url=BASEPATH."/login.php";
           header("location:$url");
       }
    }
    /**
     * 展示员工列表
     * @param number $pageNo
     * @param number $pageSize
     */
    public function laodEmployeeList($pageNo=1,$pageSize=3) {
       //总数量
       $total=$this->UserMode->count();
       //当前页的数据
       $rows=$this->UserMode->page($pageNo,$pageSize)->select();
       $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
       $this->ajaxReturn($page);
    }
    
    /**
     * 访问模版测试
     */
    public function text(){
        //保存数据assign("aaa","XXX")
        $this->assign("aaa","测试模版");
        
        $array1=array("数组1","数组2");
        $this->assign("array1",$array1);
        $array2=array("name"=>邹吉,"age"=>22);
        $this->assign("array2",$array2);
         
        $obj=new TreeNode();
        $obj->id="1";
        $obj->text="测试对象";
        $this->assign("obj",$obj);
        
        $o=new \stdClass();
        $o->name="邹吉";
        $this->assign("o",$o);
        
        $this->assign("time",time());
        
        $array3=array(["张三",18],["李四",22]);
        $this->assign("array3",$array3);
        
        //访问View模版
        $this->display();
    }
    /**
     * 同步提交加载客户信息并以boostrap表格列表展示
     */
    public function boostrapLoadClientListShow($pageNo=1,$pageSize=2){
        //总数量
        $total=$this->ClientMode->count();
        //当前页的数据
        $rows=$this->ClientMode->page($pageNo,$pageSize)->select();
        $page=array("total"=>$total,"rows"=>$rows,"pageNo"=>$pageNo,"pageSize"=>$pageSize);
        $this->assign("BASEPATH",BASEPATH);//保存数据方便页面使用
        $this->assign("boostrapPageClientList",$page);//保存数据方便页面使用
        $this->display("boostrapLoadClientListShow");     
        
    }
    
    /**
     * 同步提交增加或者修改客户信息
     */
    function addOrUpdate(){
        $data=$this->ClientMode->create();
        if($data["cid"] < 0){//增加客户信息
            $this->ClientMode->field("name,phone,site,level,eid")->add($data);
    
        }else{//修改客户信息
            $this->ClientMode->field("name,phone,site,level,eid")->where("cid='%d",$data["cid"])->save();
        }
        $this->boostrapLoadClientListShow();
    }
    
    /**
     * 通过客户id查数据回填表单
     */
    function ByClicentIDBackfillFrom($cid){
        $data=$this->ClientMode->find($cid);
        $this->ajaxReturn($data);
    }
} 

?>