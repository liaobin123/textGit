<?php
namespace Home\Controller\Index;
use Think\Controller;
use Think\Upload;
class IndexController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    /**
     * 同步提交上传文件
     */
    public function upPicture(){
        $config=array(
            "maxSize"=>0,//设置文件大小
            "rootPath"=>"./Public/",//设置根目录
            "savePath"=>"",//上传保存的路径（相对路径）
            "atuoSub"=>true,//自动使用子目录保存文件
            "subName"=>"upPicture",//创建子目录
            "saveName"=>round(0,1000)."".time(),//上传文件的保存命名
            "exts"=>"jpg,png,gif"//限制上传文件的格式  
        );
        $upPicture=new Upload($config);
        $info=$upPicture->uploadOne($_FILES["picture"]);
        if(!$info){
            echo $upPicture->getError();
        }else {
            print_r($info);
        }
    }
    
    /**
     * 异步提交上传文件
     */
    public function upPicture2(){
        $config=array(
            "maxSize"=>0,//设置文件大小
            "rootPath"=>"./Public/",//设置根目录
            "savePath"=>"",//上传保存的路径（相对路径）
            "atuoSub"=>true,//自动使用子目录保存文件
            "subName"=>"upPicture",//创建子目录
            "saveName"=>round(0,1000)."".time(),//上传文件的保存命名
            "exts"=>"jpg,png,gif"//限制上传文件的格式
        );
        $upPicture=new Upload($config);
        $info=$upPicture->uploadOne($_FILES["picture"]);
        if(!$info){
            echo $upPicture->getError();
        }else {
            $this->ajaxReturn($info);
        }
    }
    
    
    
    
}