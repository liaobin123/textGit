<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="<?php echo ($BASEPATH); ?>Public/bootstrap/css/bootstrap.min.css" type="text/css"/>
<script type="text/javascript" src="<?php echo ($BASEPATH); ?>Public/bootstrap/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo ($BASEPATH); ?>Public/bootstrap/js/bootstrap.min.js"></script>
</head>
<script type="text/javascript">
	function turnpage(pageNo,pageSize,type){
		if(type == -1){
			pageNo = pageNo-1;
			if(pageNo == 0){
				alert("已经是第一页了");
				return;
			}
		}else if(type == 0){
			pageNo = pageNo+1;
			var a=parseInt(<?php echo ($boostrapPageClientList["total"]); ?> / pageSize);
			var b=parseInt(<?php echo ($boostrapPageClientList["total"]); ?> % pageSize);
			if(b > 0){
				a +=1;
			}
			if(pageNo > a){
				alert("已经是最后一页了");
				return;
			}
			
		}else{
			pageNo = type;
			
		}
		location.href="<?php echo ($BASEPATH); ?>index.php/Home/User/User/boostrapLoadClientListShow?pageNo="+pageNo+"&pageSize="+pageSize;
	}
	function addOrUpdate(type){
		if(type == 1){
			//传来的是1就是新增
			$("#myModal").modal('toggle');//打开模态窗
			$("#cid").val("-1");
		}else{
			//修改
			var cids=$("input[name=cid]:checked");
			if(cids.length !=1 ){
				alert("请选择一行数据进行操作");
				return;
			}
			$("#myModal").modal('toggle');//打开模态窗
			$.post("<?php echo ($BASEPATH); ?>index.php/Home/User/User/ByClicentIDBackfillFrom",{cid:cids.val()},function(data){
				$("#cid").val(data.cid);
				$("#clientName").val(data.name);
				$("#phone").val(data.phone);
				$("#site").val(data.site);
				$("#level").val(data.level);
				$("#employeeID").val(data.eid);
			},"json");
		}
	}
</script>
<body>
	<div>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick="addOrUpdate(1)"><span class="glyphicon glyphicon-plus"></span>新增</button>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick="addOrUpdate(2)"><span class="glyphicon glyphicon-pencil"></span>修改</button>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-remove"></span>删除</button>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-share-alt"></span>导出Excel</button>
	</div>
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">新增/修改</h4>
	      </div>
	       <form action="<?php echo ($BASEPATH); ?>index.php/Home/User/User/addOrUpdate" method="post">
	      		<div class="modal-body">
	      			<input type="hidden" value="" name="cid" id="cid">
					<div class="form-group form-inline has-feedback">
						<label style="width: 20%;">客户姓名：</label>
						<input type="text" class="form-control has-error nam" name="name" id="clientName" style="width: 90%;" placeholder="请输入" /> 
					</div>
				
					<div class="form-group form-inline has-feedback">
						<label style="width: 20%;">电话：</label>
						<input type="text" class="form-control has-error nam" name="phone" id="phone" style="width: 90%;" placeholder="请输入" /> 
					</div>
					
					
					<div class="form-group form-inline has-feedback">
						<label style="width: 20%;">地址：</label>
						<input type="text" class="form-control has-error nam" name="site" id="site" style="width: 90%;" placeholder="请输入" /> 
					</div>
					<div class="form-group form-inline has-feedback">
						<label style="width: 20%;">等级：</label>
						<input type="text" class="form-control has-error nam" name="level" id="level" style="width: 90%;" placeholder="请输入" /> 
					</div>
					<div class="form-group form-inline has-feedback">
						<label style="width: 20%;">跟踪员工编号：</label>
						<input type="text" class="form-control has-error nam" name="eid" id="employeeID" style="width: 90%;" placeholder="请输入" /> 
					</div>
					<div class="form-group form-inline has-feedback">
						<div class="modal-footer">
					        <button type="reset" class="btn btn-default">取消</button>
					        <button type="submit" class="btn btn-primary">确认</button>
					    </div>
				    </div>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	
	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th><input type="checkbox" name=""/></th>
			<th>编号</th>
			<th>客户姓名</th>
			<th>客户电话</th>
			<th>客户地址</th>
			<th>级别</th>
			<th>跟踪员工</th>
		</tr>
		<?php if(is_array($boostrapPageClientList["rows"])): foreach($boostrapPageClientList["rows"] as $key=>$c): ?><tr>
				<td><input type="checkbox" name="cid" value="<?php echo ($c["cid"]); ?>"/></td>
				<td><?php echo ($c["cid"]); ?></td>
				<td><?php echo ($c["name"]); ?></td>
				<td><?php echo ($c["phone"]); ?></td>
				<td><?php echo ($c["site"]); ?></td>
				<td><?php echo ($c["level"]); ?></td>
				<td><?php echo ($c["eid"]); ?></td>
			</tr><?php endforeach; endif; ?>
	</table>
	<nav aria-label="Page navigation" class="text-center">
		<ul class="pagination">
			<li><a href="javascript:return false;">当前显示第<span style="color:red;"><?php echo ($boostrapPageClientList["pageNo"]); ?></span>页</a></li>
		    <li>
		      	<a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,-1);" aria-label="Previous">
		        	<span aria-hidden="true">&laquo;</span>
		      	</a>
		    </li>
		    <li><a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,1);">1</a></li>
		    <li><a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,2);">2</a></li>
		    <li><a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,3);">3</a></li>
		    <li><a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,4);">4</a></li>
		    <li><a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,5);">5</a></li>
		    <li>
		      	<a href="javascript:turnpage(<?php echo ($boostrapPageClientList["pageNo"]); ?>,<?php echo ($boostrapPageClientList["pageSize"]); ?>,0);" aria-label="Next">
		        	<span aria-hidden="true">&raquo;</span>
		      	</a>
		    </li>
		    <li><a href="javascript:return false;">共<span style="color:red;"><?php echo ($boostrapPageClientList["total"]); ?></span>条数据</a></li>
		</ul>
	</nav>
	
</body>
<ml>