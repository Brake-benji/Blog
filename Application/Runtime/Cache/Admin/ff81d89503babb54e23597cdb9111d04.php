<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>友情链接列表</title>
		<link rel="stylesheet" href="/AuthOne/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/AuthOne/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/AuthOne/Public/plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div class="admin-main">
		
			<blockquote class="layui-elem-quote">
				<button  class="layui-btn layui-btn-small add">
					<i class="layui-icon">&#xe608;</i> 添加友链
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>友链列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>添加人</th>
					      <th>友链名称</th>
					      <th>友链地址</th>
					      <th>添加时间</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
					      <td><?php echo ($vo["nickname"]); ?></td>
					      <td><?php echo ($vo["linkname"]); ?></td>
					      <td><?php echo ($vo["linkurl"]); ?></td>
					      <td><?php echo (date('Y-m-d H:i',$vo["createtime"])); ?></td>
					      <td>
							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
							<a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>
					      </td>
					    </tr><?php endforeach; endif; ?>
					  </tbody>
				</table>
			
				</div>
			</fieldset>
			<div class="admin-table-page">
				<div id="page" class="page">
				<?php echo ($page); ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/AuthOne/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
					$ = layui.jquery
					//请求表单
				 $('.add').click(function(){
					var url = "<?php echo U('Other/addLinks');?>";
					$.get(url,function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'添加友情链接',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				//编辑用户
				$('.edit').click(function(){
					var user_id = $(this).attr('data');
					var url = "<?php echo U('Other/editLinks');?>";
					$.get(url,{id:user_id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'编辑用户',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//删除
				$('.del').click(function(){
					var user_id = $(this).attr('data');
					var url = "<?php echo U('Other/delLinks');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{id:user_id},function(data){
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