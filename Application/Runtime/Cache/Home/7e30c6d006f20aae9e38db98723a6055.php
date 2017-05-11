<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title><?php echo ($title); ?></title>
	<meta charset="utf-8">
	<meta keywords="青椒白饭，青椒白饭Mr.Xie,青椒白饭Mr.Xie的个人博客，个人博客，博客，个人网站，个人主页">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="/Blog/Public/css/Home/index.css" media="all">
	<link rel="stylesheet" href="/Blog/Public/plugins/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="/Blog/Public/css/global.css" media="all">
	<link rel="stylesheet" href="/Blog/Public/plugins/font-awesome/css/font-awesome.min.css">
	
</head>
<body>
	<!-- header start -->
	<div class="header-content">
		<div class="header-main">
			<ul class="layui-nav" style="padding:0px;border-radius: 0px;width:600px;display: inline-block;"	>
			<li class="layui-nav-item layui-this"><a href="<?php echo U('Index/index');?>">首页</a></li>
			  <?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo['son'])): $i = 0; $__LIST__ = $vo['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ko): $mod = ($i % 2 );++$i;?><li class="layui-nav-item">
				  	<?php if(!empty($ko['son'])): ?><a href="/Blog/index.php/Home/Index/category/cid/<?php echo ($ko["id"]); ?>"><?php echo ($ko["title"]); ?></a>
				  		<dl class="layui-nav-child">
				  		<?php if(is_array($ko['son'])): $i = 0; $__LIST__ = $ko['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$yo): $mod = ($i % 2 );++$i;?><dd><a href="/Blog/index.php/Home/Index/category/cid/<?php echo ($yo["id"]); ?>"><?php echo ($yo["title"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?>
				  		</dl>			 
				  	<?php else: ?>
				  	<a href="/Blog/index.php/Home/Index/category/cid/<?php echo ($ko["id"]); ?>"><?php echo ($ko["title"]); ?></a><?php endif; ?>
				  	</li><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>

			<div class="search-form">
				<div class="layui-form-item" style="margin-bottom: 0px;height: 60px;">
				    <div class="layui-input-block" style="top:11px;">
				      <input type="text" name="keyword" id="keyword" required  lay-verify="required" placeholder="请输入文章标题或标签" autocomplete="off" class="layui-input" style="border-radius: 20px;"><i class="layui-icon" style="position: absolute;float: right;top: -8px;right: 10px;cursor: pointer;">&#xe615;</i>   
				    </div>
				  </div>
			</div>
		</div>
	</div>
	<!-- header end-->