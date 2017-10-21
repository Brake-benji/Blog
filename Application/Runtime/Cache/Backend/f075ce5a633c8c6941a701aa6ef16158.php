<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form" enctype="multipart/form-data" method="post">
  <div class="layui-form-item activity">
    <div class="layui-input-inline" style="width:450px;margin-top: 10px;">
      <label class="layui-form-label">当前密码</label>
      <input type="password" name="oldpwd" lay-verify="required" placeholder="请输入当前密码" autocomplete="off"  id="slogan" class="layui-input adinput" style="width: 300px;margin-bottom: 10px;">
      <label class="layui-form-label">输入新密码</label>
      <input type="password" name="password" lay-verify="required" placeholder="请输入新密码" autocomplete="off"  id="slogan" class="layui-input adinput" style="width: 300px;margin-bottom: 10px;">
      <label class="layui-form-label">确认新密码</label>
      <input type="password" name="repwd" placeholder="请确认新密码" autocomplete="off"  id="url" class="layui-input adinput" style="width: 300px;margin-bottom: 10px;">
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
		var url = "<?php echo U('Admin/Index/changepwd');?>";
		$.post(url,groupInfo,function(data){
			if(data.status == "success"){
					layer.msg('修改密码成功', {
						  icon: 6,//成功的表情
						  time: 2000 //2秒关闭（如果不配置，默认是3秒）
						}, function(){
						   window.location.href = "<?php echo U('Login/logout');?>";
						}); 
				 
			  }else{
				   layer.msg(data.msg,{icon: 5});//失败的表情
				   return;
			  }
		});
		
	    return false;//阻止表单跳转
	  });
	});

</script>