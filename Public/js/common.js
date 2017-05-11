var _static = "/Blog";

layui.use(['jquery','element','layer'], function(){
    var layer = layui.layer;
	$ = layui.jquery;



	//轮播代码
	var index = 0; //索引值
	$('body').on('click','.activity-list .nav li',function(){
		if(!$(this).hasClass("active")){
			$(this).addClass("active").siblings().removeClass();
			var index=$(this).index()
			$('.activity-list ul li').eq(index).fadeIn().siblings().fadeOut();
			num = index;
		}
	});

	//自动滚动模块
	var num = 0;
	function autoplay(){
		num++;
		var allSize = $('.nav li').size();
		if(num > allSize){
			num = 0;
		}
		$('.activity-list ul li').eq(num).fadeIn().siblings().fadeOut();
		$('.activity-list .nav li').eq(num).addClass("active").siblings().removeClass();

		
	}

	//实现滚动效果
	timer=setInterval(autoplay, 8000);
	$('body').on({
		mouseenter:function(){
			clearInterval(timer);
		},
		mouseleave:function(){
			clearInterval(timer);
	    	timer=setInterval(autoplay, 8000);
		}
	},'.activity-list ul li');

	//留言&反馈
	$('body').on('click','#leave_message',function(){
		var url = '/Blog/index.php/Home/Index/addMessage';
		$.get(url,function(data){
			if(data.status == 'error'){
				layer.msg(data.msg,{icon: 5});
				return;
			}
			
			layer.open({
				  title:'留言&意见反馈',
				  type: 1,
				  skin: 'layui-layer-rim', //加上边框
				  area: ['500px','300px'], //宽高
				  content: data,
			});
		})
	});

});


	function search(keyword){
		var url = "/Blog/index.php/Home/Index/search/",
		params = {keyword:keyword};
		$.getJSON(url,params,function(data){
		if (data.status == "true") {
			location.href = '/Blog/index.php/Home/Index/search/keyword/'+keyword;
		}else{
			layer.open({
					title:'提示',
					content:'查询结果为空呐~'
				});
		}
		});
		
	}

	function activitylist(){
		$.getJSON(_static+'/index.php/Home/Index/getActivityList',function(data){
			if (data.status == "true") {
				var ct = [],rs = data.result;
				ct.push(	'<ul>');
				$.each(rs,function(k,v){
					ct.push(	'<li class="activity-img" data-id="'+v.id+'"><a href="'+v.linkurl+'" target="_blank" title="'+v.slogan+'"><img src="'+_static+v.filepath+'"></a></li>');
				});
				ct.push(	'</ul>');
				ct.push(	'<div class="nav">');
				$.each(rs,function(k,v){
					ct.push(	'<li data-id="'+v.id+'"></li>');
				});
				ct.push(	'</div>');
				$('.activity-list').append(ct.join(''));
				$('.activity-list ul li:first,.activity-list .nav li:first').addClass("active");
			}else{
				layer.open({
							title:'提示',
							content:data.msg
						});
			}
		});
	}



	

