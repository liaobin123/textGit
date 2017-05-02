<?php
//应用配置
return array(
	//'配置项'=>'配置值'
	
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'CRM2',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    
    'CONTROLLER_LEVEL'      =>  2,//控制器级别
    'URL_PARAMS_BIND' => true,//开启请求参数绑定
    'URL_PARAMS_BIND_TYPE'  =>  0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
    
);