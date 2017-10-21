<?php if (!defined('THINK_PATH')) exit();?>	<?php echo W('Cate/header');?>	
	<!-- bannerimg start -->
	<div class="layout-banner">
		<div class="banner_pic">
			<img src="/Public/images/Home/Banner/banner.jpg">
		</div>
	</div>
	<!-- bannerimg end -->

	<div class="text-content">
		<div class="header-main">
			<!-- article start -->
			<div class="layout-left">
				<ul>
					<?php if(is_array($cate_list)): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li class="article-list">
						<img src="<?php echo ($v["artpicture"]); ?>">
						<br>
						<p class="article_title"><?php echo ($v["title"]); ?></p>
						<br>
						<span class="article_info">
							<p class="article_content">
							<i class="layui-icon" style="font-size: 20px; color: #5FB878;">&#xe612;</i>文章作者：<?php echo ($v["nickname"]); ?></p>
							<p class="article_content">
							<i class="layui-icon" style="font-size: 20px; color: #5FB878;">&#xe630;</i>所属分类：<?php echo ($v["catename"]); ?></p>
							<p class="article_content">
							<i class="layui-icon" style="font-size: 20px; color: #5FB878;">&#xe64d;</i>所属标签：<?php echo ($v["catename"]); ?></p>
						</span>
						<span class="article_described">
							<i class="layui-icon" style="font-size: 20px; color: #5FB878;">&#xe60a;</i>内容描述：<?php echo ($v["described"]); ?> 
						</span>
						<a href="/index.php/Home/Index/detail/id/<?php echo ($v["id"]); ?>.html" class="article_detail_btn">查看详情<i class="layui-icon" style="font-size: 20px;position: absolute;line-height: 40px;right: -2px;">&#xe602;</i></a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
			<!--  article end -->
			
			<?php echo W('Cate/right');?>
			
		</div>

			<?php echo W('Cate/footer');?>
	</div>
	
	<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
	<script type="text/javascript" src="/Public/js/common.js"></script>
	<script>
		layui.use(['jquery','element','layer'], function(){
		    var layer = layui.layer;
			$ = layui.jquery;

			$('.search-form .layui-input').keydown(function(e){
				if (e.keyCode == 13) {
					var keyword = $('#keyword').val();
					if (keyword == '') {
						layer.open({
							title:'提示',
							content:'关键词不能为空'
						});
					}
					search(keyword);
				}
			});
			//活动列表初始化
			activitylist();
		});


		
	</script>
</body>
</html>