<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>发表文章</title>
		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/Public/css/other.css" media="all">
		<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
	</head>

	<body>
		<div class="admin-main">
		
			<blockquote class="layui-elem-quote">
				<a class="layui-btn layui-btn-small" href="<?php echo U('Blog/index');?>">
					<i class="layui-icon">&#xe608;</i> 文章列表
				</a>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>发表文章</legend>
				<form class="layui-form" action="" style="position: relative;top:10px;">
				  <div class="layui-form-item">
				    <label class="layui-form-label">文章标题</label>
				    <div class="layui-input-block">
				      <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
				    </div>
				  </div>
				  <div class="layui-form-item" id="articleimg">
				    <label class="layui-form-label">选择文件</label>
	  	            <input type="file" name="file" class="layui-upload-file">
	  	            <br/>
	  	          </div>
				   <div class="layui-form-item layui-form-text">
				    <label class="layui-form-label">文章描述</label>
				    <div class="layui-input-block">
				      <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
				    </div>
				  </div>
				  <div class="layui-form-item">
				    <label class="layui-form-label">选择分类</label>
				    <div class="layui-input-block">
				      <select name="category" lay-verify="required">
				        <option value=""></option>
				        <?php if(is_array($clist)): $i = 0; $__LIST__ = $clist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

				      </select>
				    </div>
				  </div>
				  <div class="layui-form-item">
				    <label class="layui-form-label">标签云</label>
				    <div class="layui-input-block">
				     <!--  <input type="checkbox" name="like[write]" title="写作">
				     <input type="checkbox" name="like[read]" title="阅读" checked>
				     <input type="checkbox" name="like[dai]" title="发呆"> -->
				      <?php if(is_array($taglist)): $i = 0; $__LIST__ = $taglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><input type="checkbox" name="tag[<?php echo ($v["id"]); ?>]" value="<?php echo ($v["id"]); ?>" title="<?php echo ($v["tagname"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
				    </div>
				  </div>
				  <div class="layui-form-item">
				    <label class="layui-form-label">是否置顶</label>
				    <div class="layui-input-block">
				      <input type="checkbox" name="istop" lay-skin="switch">
				    </div>
				  </div>
				  <div class="layui-form-item">
				    <label class="layui-form-label">是否推荐</label>
				    <div class="layui-input-block">
				      <input type="checkbox" name="isrecommend" lay-skin="switch">
				    </div>
				  </div>
				<div class="layui-form-item">
				<label class="layui-form-label">文章内容</label>
				    <script id="container" name="content" type="text/plain" style="margin-left: 100px;">
				    </script>
				    <script type="text/javascript" src="/Public/ueditor/ueditor.config.js"></script>
				    <script type="text/javascript" src="/Public/ueditor/ueditor.all.js"></script>
				    <script type="text/javascript">
				        var ue = UE.getEditor('container',{
				        	initialFrameHeight:400,
				        	initialFrameWidth:1000 
				        });
				    </script>
				</div>
	
				  <div class="layui-form-item">
				    <div class="layui-input-block" >
				      <button class="layui-btn add" lay-submit lay-filter="formSubmit">立即提交</button>
				      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
				    </div>
				  </div>
				</form>
			</fieldset>
			
			

		</div>
	</body>
	<script>
			layui.use('form', function(){
			  var form = layui.form();
			  $ = layui.jquery;
			  //监听提交
			  form.on('submit(formSubmit)', function(data){
			    var groupInfo = data.field;
				var url = "<?php echo U('Blog/addArticle');?>";
				$.post(url,groupInfo,function(data){
					if(data.status=='error'){
					  layer.msg(data.msg,{icon: 5});//失败的表情
					  return;
				  	}else{
					  layer.msg('文章发布成功', {
						  icon: 6,//成功的表情
						  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}, function(){
						   window.location.reload();
						}); 
				  	}	
				});
			    return false;
			  });

			  $('.layui-form-select dl').css('z-index','1000');
			});
			

			layui.use('upload', function(){
			  layui.upload({
				  url: "<?php echo U('Blog/saveImage');?>",
				  before: function(input){
				    //返回的参数item，即为当前的input DOM对象
				    console.log('文件上传中');
				  },
				  success: function(res){
				  	if (res.status == "success") {
				  		//上传成功，返回图片地址
				  		$ = layui.jquery;
				  		var ct = [];
				  		ct.push(	'<input type="hidden" name="imgfile" value="'+res.data+'">');
				  		ct.push(	'<img src="'+res.data+'" style="width:400px;height:200px;margin:10px 0px 10px 110px;">');
				  		$('#articleimg').append(ct.join(''));
				    	layer.msg('上传成功', {
								  icon: 6,//成功的表情
								  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}); 
				  	}else{
				  		//上传失败，返回提示信息
				  		layer.msg(res.msg,{icon: 5});//失败的表情
						return;
				  	}
				  }
				});  
			});
	</script>
</html>