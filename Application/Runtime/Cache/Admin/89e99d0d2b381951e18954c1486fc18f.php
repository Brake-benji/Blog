<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>文章列表</title>
		<link rel="stylesheet" href="/AuthOne/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/AuthOne/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/AuthOne/Public/css/other.css" media="all">
		<link rel="stylesheet" href="/AuthOne/Public/plugins/font-awesome/css/font-awesome.min.css">
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
		
			<blockquote class="layui-elem-quote">
				<a class="layui-btn layui-btn-small add" href="<?php echo U('Blog/addArticle');?>">
					<i class="layui-icon">&#xe608;</i> 添加文章
				</a>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>文章列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>文章标题</th>
					      <th>作者</th>
					      <th>封面图</th>
					      <th>所属分类</th>
					      <th>所属标签</th>
					      <th>置顶|推荐</th>
					      <th>状态</th>
					      <th>发布时间</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
					      <td><?php echo ($v["title"]); ?></td>
					      <td><?php echo ($v["nickname"]); ?></td>
					      <td><img src="/AuthOne<?php echo ($v["artpicture"]); ?>" style="width:300px;"></td>
					      <td><?php echo ($v["catename"]); ?></td>
					      <td><?php echo ($v["tagname"]); ?></td>
					      <td style="padding: 0px;">
					      	<?php if($v["istop"] == 'y'): ?><i class="layui-icon" style="font-size: 30px; color: #5FB878;">&#xe605;</i>
					      	<?php else: ?>
					      	<i class="layui-icon" style="font-size: 30px; color: #FF5722;">&#x1006;</i><?php endif; ?>|
					      	<?php if($v["isrecommend"] == 'y'): ?><i class="layui-icon" style="font-size: 30px; color: #5FB878;">&#xe605;</i>
					      	<?php else: ?>
					      	<i class="layui-icon" style="font-size: 30px; color: #FF5722;">&#x1006;</i><?php endif; ?>
					      </td>
					   	  <td>
						   	<?php if($v["is_valid"] == 'y'): ?>已发布
						   	<?php else: ?>
						   	<p style="color:#f96863;">审核中</p><?php endif; ?>
					   	  </td>
					      <td><?php echo (date("Y-m-d H:i",$v["createtime"])); ?></td>
					      <td>
					        <?php if($v["is_valid"] == 'n'): ?><button class="layui-btn layui-btn-mini layui-btn-warm release" data="<?php echo ($v["id"]); ?>" style="margin-bottom: 10px;">
					      		<i class="layui-icon">&#xe608;</i>发布</button>
					      		<br><?php endif; ?>
							<a href="editArticle/id/<?php echo ($v["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit" style="margin-bottom: 10px;"><i class="layui-icon">&#xe642;</i>编辑</a>
							<br>
							<?php if($v["is_valid"] == 'y'): ?><a  data="<?php echo ($v["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del" style="margin-bottom: 10px;"><i class="layui-icon">&#xe640;</i>删除</a><?php endif; ?>
					      </td>
					    </tr><?php endforeach; endif; ?>
					  </tbody>
				</table>
				<div class="list-page">
				<?php echo ($page); ?>
				</div>
				</div>
			</fieldset>
			
			

		</div>
		<script type="text/javascript" src="/AuthOne/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
				$ = layui.jquery

				//发布活动
				$('.release').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Blog/changeStatus');?>";
					layer.confirm('确定发布此文章吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.get(url,{id:id},function(data){
								if(data.status=='error'){
									  layer.msg(data.msg,{icon: 5});//失败的表情
									  return;
								  }else{
									  layer.msg('发布成功', {
										  icon: 6,//成功的表情
										  time: 2000 //2秒关闭（如果不配置，默认是3秒）
										}, function(){
										   window.location.reload();
										}); 
								  }	
							})
					  });
				})

				//编辑
				$('.edit').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Other/editAd');?>";
					
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'编辑角色',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				
				//删除
				$('.del').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Blog/delArticle');?>";
					layer.confirm('确定删除此文章吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.get(url,{id:id},function(data){
								if(data.status=='error'){
									  layer.msg(data.msg,{icon: 5});//失败的表情
									  return;
								  }else{
									  layer.msg('删除成功', {
										  icon: 6,//成功的表情
										  time: 2000 //2秒关闭（如果不配置，默认是3秒）
										}, function(){
										   window.location.reload();
										}); 
								  }	
							})
					  });
				})
				
			});
		</script>
	</body>

</html>