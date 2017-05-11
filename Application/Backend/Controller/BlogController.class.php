<?php
namespace Backend\Controller;

class BlogController extends CommonController{
	public function index(){
		$userinfo = $this->getUserinfo();
		if (!$userinfo) {
			$this->ajaxError("尚未登录，不能查看文章列表");
		}
		$total = M('article')->count();
		$page = new \Think\Page($total,10);
		$page->lastSuffix = false;
        $page->rollPage = 1;
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->setConfig('theme',' %FIRST% %UP_PAGE% 第%NOW_PAGE%页/共%TOTAL_PAGE%页 %DOWN_PAGE% %END% ');
		$show = $page->show();
		$articleList = M()->query("select ss.*,cc.* from (select a.*,b.nick_name as nickname,c.title as catename from article a left join admin_user b on a.uid = b.id left join admin_auth_rule c on a.cid = c.id) as ss left join (select d.aid,d.tid,e.tagname from article_tag_relate d left join tag e on d.tid = e.id) as cc on ss.id = cc.aid group by id order by createtime desc,readcounts desc limit ".$page->firstRow.",".$page->listRows);
		$this->assign('page',$show);
		$this->assign('list',$articleList);
		$this->display();
	}

	public function addArticle(){
		if (IS_POST) {
			$data = I('post.');
			$userinfo =  $this->getUserinfo();
			if (!$userinfo) {
				$this->ajaxError("尚未登录，不能发布文章");
			}
			if (empty($data['title']) || empty($data['category']) || empty($data['desc']) || empty($data['content']) || empty($data['imgfile'])) {
				$this->ajaxError("缺少必要字段");
			}
			
			M()->startTrans();
			$data['uid'] = $userinfo['uid'];
			$data['described'] = $data['desc'];
			$data['cid'] = $data['category'];
			$data['artpicture'] = $data['imgfile'];
			$data['istop'] = empty($data['istop'])?'n':'y';
			$data['isrecommend'] = empty($data['isrecommend'])?'n':'y';
			$data['is_valid'] = 'n';
			$data['createtime'] = time();
			$data['readcounts'] = '0';
			$res = M('article')->data($data)->add();
			//添加文章标签关联
			if(empty($data['tag'])){
				$addAll = true;
			}else{
				$count = count($data['tag']);
				$toArr= explode(",",implode(',', $data['tag']));
		        $allArr = array();
		        for ($i=0; $i < $count; $i++) {
		            $allArr[$i]['aid'] = $res;
		            $allArr[$i]['tid'] = $toArr[$i];
		            $allArr[$i]['createtime'] = time();
		            $allArr[$i]['is_valid'] = 'y';
		        }
		        $addAll = M('article_tag_relate')->addAll($allArr);

			}
			
			if ($res && $addAll) {
				M()->commit();
				$this->ajaxSuccess("文章发布成功");
			}else{
				M()->rollback();
				$this->ajaxError("文章发布失败");
			}
		}else{
			$menu = D('AdminMenu');
			$id = array('46','47','48','49','50','52','53');
			$allCategory = $menu->getMenus($id);  //获取分类
			$allTag = M('tag')->field('id,tagname')->order('createtime DESC')->select();
			$clist = get_column($allCategory);
			$this->assign('taglist',$allTag);
			$this->assign('clist',$clist);
			$this->display();
		}
	}

	/**
	 * 图片上传，返回图片地址
	 */
	public function saveImage(){
		$userinfo = $this->getUserinfo();
		$config = array(
		    'maxSize'    =>    3145728,
		    'rootPath'   =>    './Public/upload/Article/',
		    'savePath'   =>    '',
		    'saveName'   =>    time().'_'.$userinfo['uid'],
		    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
		    'autoSub'    =>    true,
		    'subName'    =>    array('date','Ymd'),
		);
		if (!is_dir($config['rootPath'])) {
			mkdir($config['rootPath'],0777);
		}
		$upload = new \Think\Upload($config);
		$info = $upload->upload();
		if(!$info){
			$this->ajaxError($upload->getError());
		}
		$image = new \Think\Image();
		foreach ($info as $file){
                $image->open('./Public/upload/Article/'.$file['savepath'].$file['savename']);
                $image->thumb(400,200,\Think\image::IMAGE_THUMB_CENTER)->save('./Public/upload/Article/'.$file['savepath']."thumb".$file['savename']);  //生成缩略图
            }
        //返回原图地址
        $thumb = '/Public/upload/Article/'.$file['savepath'].$file['savename'];
		$this->ajaxSuccess("上传成功",$thumb);
		
	}

	/**
	 * 文章发布
	 */
	public function changeStatus(){
		$id = I('id');
		$res = M('article')->where("id =".$id." and is_valid = 'n'")->find();
		if (empty($id) || empty($res)) {
			$this->ajaxError("该文章不存在");
		}
		$data['is_valid'] = 'y';
		$update = M('article')->where('id ='.$id)->data($data)->save();
		if ($update) {
			$this->ajaxSuccess("文章发布成功");
		}else{
			$this->ajaxError("文章发布失败");
		}
	}

	public function editArticle(){
		
		if (IS_POST) {
			//接收修改表单
			$data = I('post.');
			$userinfo =  $this->getUserinfo();
			if (!$userinfo) {
				$this->ajaxError("尚未登录，不能修改文章");
			}
			if (empty($data['title']) || empty($data['category']) || empty($data['desc']) || empty($data['content'])) {
				$this->ajaxError("缺少必要字段");
			}
			
			$data['uid'] = $userinfo['uid'];
			$data['described'] = $data['desc'];
			$data['cid'] = $data['category'];
			if (!empty($data['imgfile'])) {
				$data['artpicture'] = $data['imgfile'];
			}
			$data['istop'] = empty($data['istop'])?'n':'y';
			$data['isrecommend'] = empty($data['isrecommend'])?'n':'y';
			$data['is_valid'] = 'n';
			$res = M('article')->where("id = ".$data['id'])->data($data)->save();
			if ($res) {
				$this->ajaxSuccess("文章修改成功");
			}else{
				$this->ajaxError("文章修改失败");
			}
		}else{
			//显示页面
			$id = I('id');
			$res = M('article a')->field('a.*,b.user_name,c.title as catename,c.id as cid')->where("a.id =".$id)->join('LEFT JOIN admin_user b ON a.uid = b.id')->join("LEFT JOIN admin_auth_rule c ON a.cid = c.id")->find();
			$tag = M()->query("select tb2.id,tb2.tagname from (select * from article_tag_relate where aid = ".$res['id'].") as tb1 left join tag tb2 on tb1.tid = tb2.id");
			if ($res) {
				$menu = D('AdminMenu');
				$id = array('46','47','48','49','50','52','53');
				$allCategory = $menu->getMenus($id);  //获取分类
				$clist = get_column($allCategory);
				$this->assign('tag',$tag);
				$this->assign('clist',$clist);
				$this->assign('content',htmlspecialchars_decode($res['content']));
				$this->assign('detail',$res);
				$this->display();
			}else{
				$this->ajaxError("此文章不存在");
			}
		}
		
	}

	/**
	 * 文章删除
	 */
	public function delArticle(){
		$id = I('id');
		$res = M('article')->where("id =".$id." and is_valid = 'y'")->find();
		if ($res) {
			$data['is_valid'] = 'n';
			$update = M('article')->where("id =".$id)->data($data)->save();
			if (!$update) {
				$this->ajaxError("删除文章失败");
			}
			$this->ajaxSuccess("删除文章成功");
		}else{
			$this->ajaxError("此文章不存在");
		}
	}

	public function tag(){
		$res = M()->query("select a.id,a.tagname,a.createtime,count(b.tid) as count,c.nick_name as nickname from tag a left join article_tag_relate b on a.id = b.tid left join admin_user c on a.uid = c.id  group by id order by createtime desc");
		$this->assign('taglist',$res);
		$this->display();
	}

	public function addTag(){
		if (IS_POST) {
			$tagName = I('tagname');
			if (empty($tagName)) {
				$this->ajaxError("标签名称不能为空");
			}
			$userinfo = $this->getUserinfo();
			if (empty($userinfo)) {
				$this->ajaxError("尚未登录，不能添加标签");
			}

			$exist = M('tag')->where("tagname = '".$tagName."'")->find();
			if($exist){
				$this->ajaxError("已存在相同名称的标签");
				return;
			}

			$data['tagname'] = $tagName;
			$data['uid'] = $userinfo['uid'];
			$data['createtime'] = time();
			$res = M('tag')->data($data)->add();
			if ($res) {
				$this->ajaxSuccess("成功发布标签");
			}else{
				$this->ajaxError("标签发布失败");
			}
		}else{
			$this->display();
		}
		
	}

	public function editTag(){
		$id = I('id');
		$name = I('tagname');
		$res = M('tag')->where('id ='.$id)->find();
		if (IS_POST) {
			if (empty($id) || empty($res) || empty($name)) {
				$this->ajaxError("此标签不存在");
			}
			$userinfo = $this->getUserinfo();
			if ($res['uid'] != $userinfo['uid']) {
				$this->ajaxError("你无权修改此标签");
			}
			$data['tagname'] = $name;
			$update = M('tag')->where('id ='.$id)->data($data)->save();
			if ($update) {
				$this->ajaxSuccess("修改标签成功");
			}else{
				$this->ajaxError("修改标签失败");
			}
		}else{
			$this->assign('tag_info',$res);
			$this->display();
		}
		
	}

	public function delTag(){
		$id = I('id');
		$res = M('tag')->where('id ='.$id)->find();
		if (empty($id) || empty($res)) {
			$this->ajaxError("此标签不存在");
		}
		$userinfo = $this->getUserinfo();
		if ($res['uid'] != $userinfo['uid']) {
			$this->ajaxError("你无权删除此标签");
		}
		$update = M('tag')->where('id ='.$id)->delete();
		if ($update) {
			$this->ajaxSuccess("修改标签成功");
		}else{
			$this->ajaxError("修改标签失败");
		}
	}


}