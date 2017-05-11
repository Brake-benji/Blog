<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>网站详情</title>
		<link rel="stylesheet" href="/Blog/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/Blog/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/Blog/Public/plugins/font-awesome/css/font-awesome.min.css">
		<style type="text/css">
			.list-page {
				text-align: center;
		}
			.list-page a{
				padding: 3px 5px;
				background: #1E9FFF;
				border-radius: 2px;
				color: #fff;
			}
		</style>
	</head>

	<body>
		<div class="admin-main">
		
			<!-- <blockquote class="layui-elem-quote">
				<button  data="0" class="layui-btn layui-btn-small add">
					<i class="layui-icon">&#xe608;</i> 添加菜单
				</button>
			</blockquote> -->
			<fieldset class="layui-elem-field">
				<legend>访问列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>来源IP</th>
					      <th>访问时间</th>
					      <th>操作记录</th>
					    </tr> 
					  </thead>
					  <tbody>
						<?php if(is_array($guest_list)): foreach($guest_list as $key=>$vo): ?><tr>
						      <td><?php echo ($vo["id"]); ?></td>
						      <td><?php echo ($vo["ip_address"]); ?></td>
						      <td><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
						      <td>
						      <?php if($vo['record_id'] == '0'): ?>访问首页
							  <?php else: ?>
						      <?php echo ($vo["title"]); endif; ?>
						  	  </td>
						    </tr><?php endforeach; endif; ?>
					  </tbody>
				</table>
			
				</div>
			</fieldset>
			<div class="admin-table-page">
				<div class="list-page">
				<?php echo ($page); ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/Blog/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
					$ = layui.jquery
					//请求表单
				 $('.add').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/addMenu');?>";
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'添加菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//编辑菜单
				$('.edit').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/editMenu');?>";
					
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'编辑菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//查看opt
				$('.see').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/viewOpt');?>";
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'查看三级菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['1200px','500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//删除
				$('.del').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/deleteMenu');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{id:id},function(data){
								if(data.status == 'error'){
									  layer.msg(data.msg,{icon: 5});//失败的表情
									  return;
								  }else{
									  layer.msg(data.msg, {
										  icon: 6,//成功的表情
										  time: 2000 //2秒关闭（如果不配置，默认是3秒）
										}, function(){
										   location.reload();
										}); 
								  }	
							})
					  });
				})
				
			});
		</script>
	</body>

</html>