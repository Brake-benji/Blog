<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">修改标签</label>
    <div class="layui-input-inline">
      <input type="text" name="tagname" value="<?php echo ($tag_info["tagname"]); ?>" lay-verify="required"  autocomplete="off"  id="title" class="layui-input">
    	<input type="hidden" name="id" value="<?php echo ($tag_info["id"]); ?>" />
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="user">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script>
layui.use('form', function(){
	
	var form = layui.form(),
   		 $ = layui.jquery
   	$("button[type=reset]").click();
	  //监听提交
	  form.on('submit(user)', function(data){
		  
	    var groupInfo = data.field;
	    
		var url = "<?php echo U('Blog/editTag');?>";
		$.post(url,groupInfo,function(data){
			if(data.status=='error'){
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
		
	    return false;//阻止表单跳转
	  });
	});
</script>