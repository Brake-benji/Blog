<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form" enctype="multipart/form-data" method="post">
  <div class="layui-form-item activity">
    
  	<label class="layui-form-label">选择文件</label>
  	<input type="file" name="file" class="layui-upload-file">
  	<br/>
  	<img src="/Blog<?php echo ($adinfo["filepath"]); ?>" style="width: 200px;height:100px;margin-left: 22%;padding: 3px;">
    <div class="layui-input-inline" style="width:450px;">
      <label class="layui-form-label">活动标语</label>
      <input type="text" name="slogan" lay-verify="required" value="<?php echo ($adinfo["slogan"]); ?>" autocomplete="off"  id="slogan" class="layui-input adinput">
      <label class="layui-form-label">活动描述</label>
      <textarea type="text" name="comment" lay-verify="required" value="<?php echo ($adinfo["comment"]); ?>" autocomplete="off"  id="comment" class="layui-textarea adinput">
      </textarea>
      <label class="layui-form-label">活动链接</label>
      <input type="text" name="url" value="<?php echo ($adinfo["linkurl"]); ?>" autocomplete="off"  id="url" class="layui-input adinput">
      <label class="layui-form-label">权重(排序)</label>
      <input type="text" name="priority" lay-verify="required" value="<?php echo ($adinfo["priority"]); ?>" autocomplete="off"  id="priority" class="layui-input adinput">
      <input type="hidden" name="id" value="<?php echo ($adinfo["id"]); ?>">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="user" >立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script>
layui.use('form', function(){
	var form = layui.form(),
   	$ = layui.jquery
   	//$("button[type=reset]").click();	
	  //监听提交
	  form.on('submit(user)', function(data){
		  
	    var groupInfo = data.field;
		var url = "<?php echo U('Admin/Other/editAd');?>";
		$.post(url,groupInfo,function(data){
			if(data.status == "success"){
					layer.msg('活动修改成功', {
						  icon: 6,//成功的表情
						  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}, function(){
						   location.reload();
						}); 
				 
			  }else{
				   layer.msg(data.msg,{icon: 5});//失败的表情
				   return;
			  }
		});
		
	    return false;//阻止表单跳转
	  });
	});
 	

layui.use('upload', function(){
  layui.upload({
	  url: "<?php echo U('Other/saveImage');?>",
	  before: function(input){
	    //返回的参数item，即为当前的input DOM对象
	    console.log('文件上传中');
	  },
	  success: function(res){
	  	if (res.status == "success") {
	  		//上传成功，返回图片地址
	  		$ = layui.jquery;
	  		var ct = [];
	  		ct.push(	'<input type="hidden" name="adfile" value="'+res.data+'">');
	  		$('.activity').append(ct.join(''));
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