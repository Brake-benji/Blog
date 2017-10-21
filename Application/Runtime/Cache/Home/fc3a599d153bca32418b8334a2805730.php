<?php if (!defined('THINK_PATH')) exit();?><!-- rightside start-->
<div class="layout-right">
	<!--mydetail-->
	<div class="mydetail">
		<h3>博主信息</h3>
		<ol class="mydetail_content">
			<li>Name：青椒白饭Mr.Xie</li>
			<li>Occupation：PHP程序猿，伪前端~</li>
			<li>Slogan：总有人要赢的，为什么不是我呢？</li>
		</ol>
	</div>
	<!--mydetail-->

	<!-- carousel start-->
	<div class="activity-list">
		<h3>活动列表</h3>
	</div>
	<!-- carousel end-->
	
	<!-- hotlist start-->
	<div class="hot-article-list" style="margin-top: 20px;">
		<h3>热门文章</h3>
		<ol class="hot_article_content">
			<?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/detail',array('id' => $vo['id']));?>"><?php echo ($vo["title"]); ?></a><span class="hits"><?php echo ($vo["readcounts"]); ?>阅读</span></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ol>
	</div>
	<!-- hotlist start-->
	
	<!-- taglist start -->
	<div class="tag-list">
		<h3>标签云</h3>
		<ol>
			<?php if(is_array($tag_list)): $i = 0; $__LIST__ = $tag_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/tagcate',array('tagid' => $v['id']));?>"><li class="tag_name"><?php echo ($v["tagname"]); ?>(<?php echo ($v["count"]); ?>篇)</li></a><?php endforeach; endif; else: echo "" ;endif; ?>
		</ol>
	</div>
	<!-- taglist end -->
</div>
<!-- rightside end -->