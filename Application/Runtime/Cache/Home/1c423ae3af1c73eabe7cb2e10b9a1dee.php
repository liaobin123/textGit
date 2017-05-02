<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>模版</title>
</head>
<body>
	测试模版取值，取得assign（）传来的值  ：<br /><br />
	aaa=<?php echo ($aaa); ?><br />
	数组：索引数组<br />
	array1=<?php echo ($array1[0]); ?><br />
	array2=<?php echo ($array1[1]); ?><br />
	<br />关联数组<br />
	名字=<?php echo ($array2["name"]); ?><br />
	年龄=<?php echo ($array2["age"]); ?><br />
	<br />取得对象<br />
	取得的对象=<?php echo ($obj->text); ?><br />
	对象名字=<?php echo ($o->name); ?><br />
	<br />
	现在时间是:<?php echo date("Y-m-d",$time);?>
	<br />变量测试<br />
	<?php if(is_array($array3)): $i = 0; $__LIST__ = $array3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo[0]); ?>:<?php echo ($vo[1]); ?><br /><?php endforeach; endif; else: echo "" ;endif; ?>
	
</body>
</html>