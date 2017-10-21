<?php if (!defined('THINK_PATH')) exit();?><!-- footer start -->
<div class="layui-footer footer-content">
	<div class="footer_info">
		<div class="friend_links">
			<span class="links_title">友情链接</span><br>
			<?php if(is_array($link_list)): $i = 0; $__LIST__ = $link_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo ($v["linkurl"]); ?>" target="_blank"><span class="links_name"><?php echo ($v["linkname"]); ?></span></a><br><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="contact_us">
			<span class="call_me_maybe" id="leave_message">联系我们&留言</span><br>
			<span class="contact_content">作者：青椒白饭Mr.Xie</span><br>
			<span class="contact_content">联系方式：776080531@qq.com</span>
		</div>
		
		<div class="copyright">
			<span class="copyright_title">青椒白饭Mr.Xie</span><br>
			<span class="copyright_content">All Rights Reserved By 青椒白饭Mr.Xie</span>
		</div>
	</div>
</div>
<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
<!-- footer end -->