<?php if (!defined('THINK_PATH')) exit();?>	<?php echo W('Cate/header');?>	

	<div class="text-content" style="position: absolute;top:80px;">
		<div class="header-main">
			<!-- article detail start -->
			<div class="layout-left">
				<div class="article-detail">
					<span class="detail-info">
						<p class="detail_title">
						<?php echo ($res["title"]); ?>
						</p>
						<p class="detail_author">
						作者：<?php echo ($res["nickname"]); ?>
						</p>
						<div class="detail-content">
							<span class="detail_cate">
								所属分类：<?php echo ($res["catename"]); ?>
							</span>
							<span class="detail_tag">
								所属标签：<?php echo ($res["tag"]); ?>
							</span>
							<span class="detail_time">
							发表时间：<?php echo (date('Y-m-d H:i:s',$res["createtime"])); ?>
							</span>
						</div>
					</span>
					<div class="detail-word">
					<?php echo ($content); ?>
					</div>
				</div>
			</div>
			<!--  article detail end -->
			
			<?php echo W('Cate/right');?>
			
		</div>

			<?php echo W('Cate/footer');?>
	</div>
	
	<script type="text/javascript" src="/Blog/Public/plugins/layui/layui.js"></script>
	<script type="text/javascript" src="/Blog/Public/js/common.js"></script>
	<script>
		layui.use('element', function(){
		    var element = layui.element();

		});

		layui.use('layer', function(){
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