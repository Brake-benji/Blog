<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">友链名称</label>
    <div class="layui-input-inline">
      <input type="text" name="linkname" lay-verify="required" placeholder="请输入友链名称" value="<?php echo ($link["linkname"]); ?>" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">友链地址</label>
    <div class="layui-input-inline">
      <input type="text" name="url" placeholder="请输入友链地址" value="<?php echo ($link["linkurl"]); ?>" class="layui-input">
    </div>
  </div>
  <input type="hidden" value="<?php echo ($link["id"]); ?>" name="id">
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
	  //监听提交
	  form.on('submit(user)', function(data){
	    var dataInfo = data.field;
		var url = "<?php echo U('Other/editLinks');?>";
		$.post(url,dataInfo,function(data){
			if(data.status == 'error'){
				  layer.msg(data.msg,{icon: 5});//失败的表情
				  return;
			  }else if(data.status == 'success'){
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